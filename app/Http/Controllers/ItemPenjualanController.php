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
            $item_penjualan = ItemPenjualan::where('penjualan_id', $sale->id)
                ->where('produk_id', $product->id)
                ->lockForUpdate()
                ->first();

            if ($item_penjualan) {
                $item_penjualan->kuantitas += $request->quantity;
            } else {
                $item_penjualan = new ItemPenjualan([
                    'penjualan_id' => $sale->id,
                    'produk_id'    => $product->id,
                    'kuantitas'    => $request->quantity,
                    'harga_satuan' => $product->harga_jual,
                ]);
            }

            $item_penjualan->subtotal = $item_penjualan->kuantitas * $item_penjualan->harga_satuan;
            $item_penjualan->save();

            $sale->total_pembayaran = $sale->itemPenjualan()->sum('subtotal');
            $sale->save();
        });

        return back();
    }

    public function update(Request $request, ItemPenjualan $item_penjualan)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1'
        ]);

        DB::transaction(function () use ($request, $item_penjualan) {

            // ✅ Query langsung tanpa relasi
            $produk = Produk::lockForUpdate()->findOrFail($item_penjualan->produk_id);

            $selisih = $request->quantity - $item_penjualan->kuantitas;

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
            $item_penjualan->update([
                'kuantitas' => $request->quantity,
                'subtotal'  => $request->quantity * $item_penjualan->harga_satuan
            ]);

            // ✅ Update total penjualan
            $penjualan = Penjualan::findOrFail($item_penjualan->penjualan_id);
            $penjualan->update([
                'total_pembayaran' => $penjualan->itemPenjualan()->sum('subtotal')
            ]);
        });

        return back();
    }

    public function destroy(ItemPenjualan $item_penjualan)
    {
        $this->authorize('delete', $item_penjualan);

        DB::transaction(function () use ($item_penjualan) {

            $produk = $item_penjualan->produk;
            $sale   = $item_penjualan->penjualan;

            // 🔵 Kembalikan stok (dicek dulu biar tidak error kalau produk sudah terhapus)
            if ($produk) {
                $produk->increment('stok', $item_penjualan->kuantitas);
            }

            // ❌ Hapus item
            $item_penjualan->delete();

            // ✅ Update total penjualan
            if ($sale) {
                $sale->update([
                    'total_pembayaran' => $sale->itemPenjualan()->sum('subtotal')
                ]);
            }
        });

        return back();
    }
}