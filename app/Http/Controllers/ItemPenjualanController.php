<?php

namespace App\Http\Controllers;

use App\Models\ItemPenjualan;
use App\Models\Penjualan;
use App\Models\Produk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ItemPenjualanController extends Controller
{
    public function index() {}
    public function create() {}
    public function show(string $id) {}
    public function edit(string $id) {}

    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:produk,id',
            'quantity'   => 'required|integer|min:1'
        ]);

        DB::transaction(function () use ($request) {

            $sale = Penjualan::where('user_id', Auth::id())
                ->where('status', 'OPEN')
                ->firstOrFail();

            $product = Produk::lockForUpdate()->findOrFail($request->product_id);

            // ! cek stok
            if ($product->stok < $request->quantity) {
                return redirect()->route('penjualan.create')->with('errors', 'Produk stok tidak mencukupi');
            }

            // ✅ Kurangi stok
            $product->decrement('stok', $request->quantity);

            // + Update / insert item penjualan
            $item = ItemPenjualan::where('penjualan_id', $sale->id)
                ->where('produk_id', $product->id)
                ->lockForUpdate()
                ->first();

            if ($item) {
                $item->kuantitas += $request->quantity;
            } else {
                $item = new ItemPenjualan([
                    'penjualan_id' => $sale->id,
                    'produk_id'    => $product->id,
                    'kuantitas'    => $request->quantity,
                    'harga_satuan' => $product->harga_jual,
                ]);
            }

            $item->subtotal = $item->kuantitas * $item->harga_satuan;
            $item->save();

            $sale->total_pembayaran = $sale->itemPenjualan()->sum('subtotal');
            $sale->save();
        });

        return back();
    }

    public function update(Request $request, ItemPenjualan $itempenjualan)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1'
        ]);

        DB::transaction(function () use ($request, $itempenjualan) {

            // ✅ Query langsung tanpa relasi
            $produk = Produk::lockForUpdate()->findOrFail($itempenjualan->produk_id);

            $selisih = $request->quantity - $itempenjualan->kuantitas;

            // 🔴 Jika qty bertambah → kurangi stok
            if ($selisih > 0) {
                if ($produk->stok < $selisih) {
                    return redirect()->route('penjualan.create')->with('errors', 'Stok tidak mencukupi');
                }
                $produk->decrement('stok', $selisih);
            }

            // 🟢 Jika qty berkurang → kembalikan stok
            if ($selisih < 0) {
                $produk->increment('stok', abs($selisih));
            }

            // ✅ Update item
            $itempenjualan->update([
                'kuantitas' => $request->quantity,
                'subtotal'  => $request->quantity * $itempenjualan->harga_satuan
            ]);

            // ✅ Update total penjualan
            $penjualan = Penjualan::findOrFail($itempenjualan->penjualan_id);
            $penjualan->update([
                'total_pembayaran' => $penjualan->itemPenjualan()->sum('subtotal')
            ]);
        });

        return back();
    }

    public function destroy(ItemPenjualan $itempenjualan)
    {
        $this->authorize('delete', $itempenjualan);
        
        DB::transaction(function () use ($itempenjualan) {

            $produk = $itempenjualan->produk;
            $sale   = $itempenjualan->penjualan;

            // 🔵 Kembalikan stok
            $produk->increment('stok', $itempenjualan->kuantitas);

            // ❌ Hapus item
            $itempenjualan->delete();

            // ✅ Update total penjualan
            $sale->update([
               'total_pembayaran' => $sale->itemPenjualan()->sum('subtotal')
            ]);
        });

        return back();
    }
}