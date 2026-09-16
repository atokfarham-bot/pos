@extends('layouts.app')

@section('title', 'POS')

@section('content')

    @include('layouts.navbar')

    @if (session('errors'))
        <div class="alert alert-danger alert-dismissible fade show mt-2" role="alert">
            {{ session('errors') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show mt-2" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <h4 class="mb-3">
        {{ $mode === 'edit' ? 'Edit Penjualan' : 'Tambah Penjualan' }}
    </h4>

    <div class="row">

        {{-- =================== PRODUK =================== --}}
        <div class="col-md-6">
            <div class="card">
                <div class="card-body" style="max-height:70vh; overflow:auto">
                    <div class="mb-3">
                        <form method="GET" action="{{ route('penjualan.create') }}">
                            <input type="text" name="search" value="{{ request('search') }}" class="form-control"
                                placeholder="Cari produk..." onkeyup="this.form.submit()">
                        </form>
                    </div>
                    @foreach ($products as $product)
                        <form method="POST" action="{{ route('item-penjualan.store') }}" class="row mb-2">
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $product->id }}">

                            <div class="col-7">
                                <button class="btn btn-outline-primary w-100 text-start p-2"
                                    {{ $sale->status === 'COMPLETED' ? 'disabled' : '' }}>
                                    <div class="d-flex align-items-center gap-2">

                                        {{-- Gambar Produk --}}
                                        <img src="{{ asset('storage/' . $product->foto) }}" alt="Gambar"
                                            class="rounded-circle" style="width:45px; height:45px; object-fit:cover;">

                                        {{-- Nama & Harga --}}
                                        <div>
                                            <div class="fw-semibold">{{ $product->nama }}</div>
                                            <small class="text-muted">Rp {{ number_format($product->harga_jual) }}</small>
                                        </div>
                                    </div>
                                </button>
                            </div>
                            <div class="col-3">
                                <input type="number" name="quantity" value="1" min="1"
                                    class="form-control {{ $sale->status === 'COMPLETED' ? 'readonly' : '' }}">
                            </div>
                            <div class="col-2">
                                <button
                                    class="btn btn-primary w-100 {{ $sale->status === 'COMPLETED' ? 'disabled' : '' }}">+</button>
                            </div>
                        </form>
                    @endforeach
                </div>
            </div>
        </div>

        {{-- =================== KERANJANG =================== --}}
        <div class="col-md-6">
            <div class="card">
                <table class="table table-bordered mb-0">
                    <thead>
                        <tr>
                            <th>Produk</th>
                            <th>Harga</th>
                            <th>Qty</th>
                            <th>Subtotal</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($sale->itemPenjualan as $item)
                            <tr>
                                <td>{{ $item->produk->nama }}</td>
                                <td>Rp {{ number_format($item->produk->harga_jual) }}</td>
                                <td>
                                    <form method="POST" action="{{ route('item-penjualan.update', $item->id) }}">
                                        @csrf @method('PUT')
                                        <input type="number" name="quantity" value="{{ $item->kuantitas }}"
                                            class="form-control form-control-sm" onchange="this.form.submit()">
                                    </form>
                                </td>
                                <td>Rp {{ number_format($item->subtotal) }}</td>
                                <td>
                                    @can('delete', $item)
                                        <form method="POST" action="{{ route('item-penjualan.destroy', $item->id) }}">
                                            @csrf @method('DELETE')
                                            <button class="btn btn-danger btn-sm">Hapus</button>
                                        </form>
                                    @endcan
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted">
                                    Keranjang kosong
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                <div class="card-footer">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <span>Total Pembayaran:</span>
                        <strong class="fs-5 text-primary">Rp {{ number_format($sale->total_pembayaran) }}</strong>
                    </div>

                    @if ($sale->status === 'COMPLETED')
                        <div class="alert alert-success mt-2 mb-2">
                            <div>Metode: <strong>{{ $sale->metode_pembayaran }}</strong></div>
                            @if ($sale->metode_pembayaran === 'CASH')
                                <div>Uang Diterima: <strong>Rp {{ number_format($sale->uang_diterima) }}</strong></div>
                                <div>Kembalian: <strong>Rp {{ number_format($sale->kembalian) }}</strong></div>
                            @endif
                        </div>
                    @else
                        <form method="POST" action="{{ route('penjualan.update', $sale->id) }}"
                            onsubmit="return validasiCheckout()" class="mt-2">
                            @csrf
                            @method('PUT')

                            <select name="metode_pembayaran" id="metode_pembayaran" class="form-select mb-2"
                                onchange="togglePaymentFields()">
                                <option value="">Pilih Pembayaran</option>
                                <option value="CASH" {{ old('metode_pembayaran') === 'CASH' ? 'selected' : '' }}>Cash
                                </option>
                                <option value="QRIS" {{ old('metode_pembayaran') === 'QRIS' ? 'selected' : '' }}>QRIS
                                </option>
                            </select>

                            {{-- Dynamic Cash Input Fields --}}
                            <div id="cash-fields" style="display:none;">
                                <input type="number" name="uang_diterima" id="uang_diterima" class="form-control mb-2"
                                    placeholder="Uang diterima" min="0" value="{{ old('uang_diterima') }}"
                                    oninput="hitungKembalian()">

                                <div class="alert alert-info py-2 px-3 mb-2" id="kembalian-box">
                                    Kembalian: <strong id="kembalian-text">Rp 0</strong>
                                </div>
                            </div>

                            {{-- Dynamic QRIS Field --}}
                            <div id="qris-fields" class="text-center mb-2" style="display:none;">
                                <img src="{{ asset('images/qris.png') }}" alt="QRIS"
                                    class="img-fluid border rounded p-2" style="max-width:220px;">
                                <p class="text-muted mt-2 mb-0">
                                    Scan QRIS untuk bayar
                                    <strong>Rp {{ number_format($sale->total_pembayaran ?? 0) }}</strong>
                                </p>
                            </div>

                            <button class="btn btn-success w-100">
                                Checkout
                            </button>
                        </form>
                    @endif

                    @can('delete', $sale)
                        <form action="{{ route('penjualan.destroy', $sale->id) }}" method="POST"
                            onsubmit="return confirm('Yakin ingin membatalkan transaksi?')">
                            @csrf
                            @method('DELETE')

                            <button type="submit"
                                class="btn btn-outline-danger w-100 mt-2 {{ $sale->status === 'COMPLETED' ? 'disabled' : '' }}">
                                Batal Transaksi
                            </button>
                        </form>
                    @endcan
                </div>
            </div>
        </div>

    </div>

    <script>
        const totalPembayaran = {{ $sale->total_pembayaran ?? 0 }};

        function togglePaymentFields() {
            const method = document.getElementById('metode_pembayaran').value;
            const cashFields = document.getElementById('cash-fields');
            const qrisFields = document.getElementById('qris-fields');

            // sembunyikan semua dulu
            cashFields.style.display = 'none';
            qrisFields.style.display = 'none';

            if (method === 'CASH') {
                cashFields.style.display = 'block';
            } else if (method === 'QRIS') {
                qrisFields.style.display = 'block';
            } else {
                // reset cash kalau bukan cash
                document.getElementById('uang_diterima').value = '';
                document.getElementById('kembalian-text').innerText = 'Rp 0';
            }
        }

        function hitungKembalian() {
            const uangDiterima = parseFloat(document.getElementById('uang_diterima').value) || 0;
            const kembalian = uangDiterima - totalPembayaran;
            const kembalianText = document.getElementById('kembalian-text');
            const kembalianBox = document.getElementById('kembalian-box');

            if (kembalian < 0) {
                kembalianText.innerText = 'Kurang Rp ' + Math.abs(kembalian).toLocaleString('id-ID');
                kembalianBox.classList.remove('alert-info', 'alert-success');
                kembalianBox.classList.add('alert-danger');
            } else {
                kembalianText.innerText = 'Rp ' + kembalian.toLocaleString('id-ID');
                kembalianBox.classList.remove('alert-info', 'alert-danger');
                kembalianBox.classList.add('alert-success');
            }
        }

        function validasiCheckout() {
            // Cek apakah keranjang kosong
            if (totalPembayaran <= 0) {
                alert('Keranjang belanja masih kosong! Tambahkan produk terlebih dahulu.');
                return false;
            }

            const method = document.getElementById('metode_pembayaran').value;

            if (method === '') {
                alert('Pilih metode pembayaran dulu!');
                return false;
            }

            if (method === 'CASH') {
                const uangDiterima = parseFloat(document.getElementById('uang_diterima').value) || 0;
                if (uangDiterima < totalPembayaran) {
                    alert('Uang diterima kurang dari total pembayaran!');
                    return false;
                }
            }

            return confirm('Yakin ingin checkout?');
        }

        document.addEventListener('DOMContentLoaded', function() {
            togglePaymentFields();
            hitungKembalian();
        });
    </script>
@endsection
