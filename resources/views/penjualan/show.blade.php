@extends('layouts.app')

@section('title', 'Struk Transaksi #' . sprintf('%06d', $sale->id ?? $penjualan->id))

@section('content')

{{-- Navbar tidak ikut tercetak saat di-print --}}
<div class="no-print">
    @include('layouts.navbar')
</div>

@php
    $data = $sale ?? $penjualan;
@endphp

<div class="container my-4">
    {{-- Header Tombol Aksi (Hanya Muncul di Layar Monitor) --}}
    <div class="d-flex justify-content-between align-items-center mb-4 no-print">
        <div>
            <h4 class="fw-bold mb-1">Detail & Struk Penjualan</h4>
            <p class="text-muted mb-0">Rincian transaksi dan cetak nota kasir</p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('penjualan.index') }}" class="btn btn-outline-secondary">
                 Kembali ke Riwayat
            </a>
            <button onclick="window.print()" class="btn btn-primary fw-bold px-4">
                 Cetak Struk
            </button>
        </div>
    </div>

    {{-- Layout Utama Struk --}}
    <div class="row justify-content-center">
        <div class="col-md-5 col-lg-4">
            <div class="receipt-card p-4 shadow-sm bg-white border mx-auto">
                
                {{-- Header Struk --}}
                <div class="text-center mb-3">
                    <h5 class="fw-bold mb-0 text-uppercase tracking-wider">TOKO FOOD</h5>
                    <small class="text-muted d-block">Jl. Golempang. No. 15, Indonesia</small>
                    <small class="text-muted d-block">Telp: 0858-6020-1095</small>
                    <div class="receipt-divider mt-2">ATOK GANTENG</div>
                </div>

                {{-- Info Transaksi --}}
                <div class="receipt-info small mb-2">
                    <div class="d-flex justify-content-between">
                        <span>No. Transaksi</span>
                        <span class="fw-bold">#{{ sprintf('%06d', $data->id) }}</span>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span>Tanggal</span>
                        <span>{{ $data->created_at ? $data->created_at->format('d/m/Y H:i:s') : date('d/m/Y H:i:s') }}</span>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span>Kasir</span>
                        <span>{{ $data->user->name ?? 'Admin' }}</span>
                    </div>
                </div>

                <div class="receipt-divider mb-2"></div>

                {{-- Item Pembelian --}}
                <div class="receipt-items small mb-2">
                    @forelse($data->itemPenjualan as $item)
                        <div class="item-row mb-1">
                            <div class="fw-semibold">{{ $item->produk->nama }}</div>
                            <div class="d-flex justify-content-between text-muted">
                                <span>{{ $item->kuantitas }} x {{ number_format($item->produk->harga_jual, 0, ',', '.') }}</span>
                                <span class="fw-bold text-dark">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</span>
                            </div>
                        </div>
                    @empty
                        <div class="text-center text-muted py-2">Tidak ada produk</div>
                    @endforelse
                </div>

                <div class="receipt-divider mb-2"></div>

                {{-- Total & Kembalian --}}
                <div class="receipt-totals small mb-3">
                    <div class="d-flex justify-content-between fw-bold fs-6 my-1">
                        <span>TOTAL</span>
                        <span>Rp {{ number_format($data->total_pembayaran, 0, ',', '.') }}</span>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span>Metode Bayar</span>
                        <span class="fw-semibold">{{ strtoupper($data->metode_pembayaran ?? 'CASH') }}</span>
                    </div>
                    
                    @if(strtoupper($data->metode_pembayaran) === 'CASH')
                        <div class="d-flex justify-content-between">
                            <span>Uang Diterima</span>
                            <span>Rp {{ number_format($data->uang_diterima ?? 0, 0, ',', '.') }}</span>
                        </div>
                        <div class="d-flex justify-content-between fw-bold text-success">
                            <span>Kembali</span>
                            <span>Rp {{ number_format($data->kembalian ?? 0, 0, ',', '.') }}</span>
                        </div>
                    @endif
                </div>

                <div class="receipt-divider mb-3"></div>

                {{-- Footer Struk --}}
                <div class="text-center small text-muted">
                    <p class="mb-1 fw-semibold">*** TERIMA KASIH ***</p>
                    <p class="mb-0">Barang yang sudah dibeli<br>tidak dapat ditukar/dikembalikan.</p>
                </div>

            </div>
        </div>
    </div>
</div>

{{-- CSS Struk Thermal & Print --}}
<style>
    .receipt-card {
        font-family: 'Courier New', Courier, monospace;
        color: #111;
        max-width: 350px;
        border-radius: 4px;
        background-color: #fff;
    }

    .receipt-divider {
        border-top: 1px dashed #666;
    }

    .tracking-wider {
        letter-spacing: 1.5px;
    }

    @media print {
        body {
            background: #fff !important;
            margin: 0;
            padding: 0;
        }

        .no-print {
            display: none !important;
        }

        .container {
            width: 100% !important;
            max-width: 100% !important;
            margin: 0 !important;
            padding: 0 !important;
        }

        .row {
            margin: 0 !important;
        }

        .col-md-5, .col-lg-4 {
            width: 100% !important;
            max-width: 80mm !important;
            margin: 0 auto !important;
            padding: 0 !important;
        }

        .receipt-card {
            box-shadow: none !important;
            border: none !important;
            width: 100% !important;
            padding: 5px !important;
        }
    }
</style>

@endsection