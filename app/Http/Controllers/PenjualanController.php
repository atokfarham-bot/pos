<?php

namespace App\Http\Controllers;

use App\Http\Requests\SearchRequest;
use App\Models\Penjualan;
use App\Models\Produk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PenjualanController extends Controller
{
    public function index(SearchRequest $request)
    {
        $user = Auth::user();
        $keyword = $request->input('search');

        $sales = Penjualan::query()
            ->when($user->role && $user->role->name === 'kasir', function ($query) use ($user) {
                $query->where('user_id', $user->id);
            })
            ->when($keyword, function ($query) use ($keyword) {
                $query->whereHas('user', function ($q) use ($keyword) {
                    $q->where('name', 'like', '%' . $keyword . '%');
                });
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('penjualan.index', compact('sales'));
    }

    public function create(SearchRequest $request)
    {
        $sale = Penjualan::with('itemPenjualan.produk')->firstOrCreate(
            [
                'user_id' => Auth::id(),
                'status'  => 'OPEN'
            ],
            [
                'total_pembayaran' => 0,
                'metode_pembayaran' => 'CASH'
            ]
        );

        $keyword = $request->input('search');

        $products = Produk::when($keyword, function ($query) use ($keyword) {
            $query->where('nama', 'like', '%' . $keyword . '%');
        })
        ->orderBy('nama')
        ->get();

        $mode = 'create';

        return view('penjualan.pos', compact('sale', 'products', 'mode'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Penjualan $penjualan)
    {
        // Eager load relasi user dan itemPenjualan beserta produknya
        $penjualan->load(['user', 'itemPenjualan.produk']);

        // Alias agar aman dipanggil sebagai $sale di view
        $sale = $penjualan;

        return view('penjualan.show', compact('sale', 'penjualan'));
    }

    /**
     * Update transaction / Checkout
     */
    public function update(Request $request, $id)
    {
        $sale = Penjualan::with('itemPenjualan')->findOrFail($id);

        if ($sale->itemPenjualan->count() === 0) {
            return redirect()->back()->with('errors', 'Keranjang belanja masih kosong! Tambahkan produk terlebih dahulu.');
        }

        $request->validate([
            'metode_pembayaran' => 'required|in:CASH,QRIS',
            'uang_diterima'     => 'required_if:metode_pembayaran,CASH|nullable|numeric|min:' . $sale->total_pembayaran,
        ], [
            'metode_pembayaran.required' => 'Metode pembayaran wajib dipilih.',
            'uang_diterima.required_if'  => 'Nominal uang diterima wajib diisi untuk pembayaran CASH.',
            'uang_diterima.min'          => 'Uang yang diterima kurang dari total pembayaran.',
        ]);

        $uangDiterima = null;
        $kembalian    = null;

        if ($request->metode_pembayaran === 'CASH') {
            $uangDiterima = $request->uang_diterima;
            $kembalian    = $uangDiterima - $sale->total_pembayaran;
        }

        $sale->update([
            'metode_pembayaran' => $request->metode_pembayaran,
            'uang_diterima'     => $uangDiterima,
            'kembalian'         => $kembalian,
            'status'            => 'COMPLETED',
        ]);

        // Redirect ke Riwayat Penjualan setelah checkout
        return redirect()->route('penjualan.index')->with('success', 'Transaksi berhasil diselesaikan.');
    }

    public function destroy(Penjualan $penjualan)
    {
        $this->authorize('delete', $penjualan);

        if ($penjualan->status !== 'OPEN') {
            return redirect()->route('penjualan.create')->with('errors', 'Transaksi sudah selesai tidak bisa dibatalkan.');
        }

        if ($penjualan->user_id !== Auth::id()) {
            return redirect()->route('penjualan.create');
        }

        DB::transaction(function () use ($penjualan) {
            foreach ($penjualan->itemPenjualan as $item) {
                $item->produk->increment('stok', $item->kuantitas);
            }

            $penjualan->itemPenjualan()->delete();
            $penjualan->delete();
        });

        return redirect()
            ->route('penjualan.index')
            ->with('success', 'Transaksi berhasil dibatalkan.');
    }
}