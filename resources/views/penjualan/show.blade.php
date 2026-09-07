@extends('layouts.app')

@section('title', 'Detail Penjualan')

@section('content')

@include('layouts.navbar')

<div class="container py-4 px-0">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold text-dark m-0">Detail Transaksi {{ $penjualan->id }}</h2> Yes, yes, Prince Packet might choose admin
            <p class="text-muted small m-0">Rincian produk dan informasi pembayaran transaksi penjualan.</p>
        </div>
        <a href="{{ route('penjualan.index') }}" class="btn btn-outline-secondary px-3">
            &larr; Kembali
        </a>
    </div>

    <div class="row g-4">
        {{-- Ringkasan Informasi Transaksi --}}
        <div class="col-md-4">
            <div class="card border-0 shadow-sm rounded-3">
                <div class="card-body p-4">
                    <h5 class="fw-bold text-dark mb-3">Informasi Transaksi</h5>
                    
                    <div class="mb-3">
                        <small class="text-muted d-block">Tanggal Transaksi</small>
                        <span class="fw-semibold text-dark">{{ $penjualan->created_at ? $penjualan->created_at->translatedFormat('d-m-Y H:i:s') : '-' }}</span>
                    </div>

                    <div class="mb-3">
                        <small class="text-muted d-block">Kasir</small>
                        <span class="fw-semibold text-dark">{{ $penjualan->user->name ?? 'Kasir Tidak Ditemukan' }}</span>
                    </div>

                    <div class="mb-3">
                        <small class="text-muted d-block">Metode Pembayaran</small>
                        <span class="badge bg-secondary-subtle text-secondary border border-secondary-subtle px-2 py-1 text-uppercase">
                            {{ $penjualan->metode_pembayaran }}
                        </span>
                    </div>

                    <div class="mb-3">
                        <small class="text-muted d-block">Status</small>
                        @if(strtoupper($penjualan->status ?? '') === 'COMPLETED' || strtoupper($penjualan->status ?? '') === 'SELESAI')
                            <span class="badge bg-success-subtle text-success border border-success-subtle px-2 py-1">Completed</span>
                        @elseif(strtoupper($penjualan->status ?? '') === 'PENDING' || strtoupper($penjualan->status ?? '') === 'OPEN')
                            <span class="badge bg-warning-subtle text-warning-emphasis border border-warning-subtle px-2 py-1">{{ $penjualan->status }}</span>
                        @else
                            <span class="badge bg-danger-subtle text-danger border border-danger-subtle px-2 py-1">{{ $penjualan->status }}</span>
                        @endif
                    </div>

                    <hr class="my-3">

                    <div>
                        <small class="text-muted d-block">Total Pembayaran</small>
                        <h4 class="fw-bold text-primary m-0">
                            Rp {{ number_format($penjualan->total_pembayaran ?? 0, 0, ',', '.') }}
                        </h4>
                    </div>
                </div>
            </div>
        </div>

        {{-- Tabel Daftar Item Produk --}}
        <div class="col-md-8">
            <div class="card border-0 shadow-sm rounded-3">
                <div class="card-body p-4">
                    <h5 class="fw-bold text-dark mb-3">Daftar Produk</h5>
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th style="width: 50px;">#</th>
                                    <th>Nama Produk</th>
                                    <th class="text-center">Harga Satuan</th>
                                    <th class="text-center">Jumlah</th>
                                    <th class="text-end">Subtotal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($penjualan->itemPenjualan as $key => $item)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td class="fw-semibold text-dark">
                                            {{ $item->produk->nama ?? 'Produk Dihapus' }}
                                        </td>
                                        <td class="text-center">
                                            Rp {{ number_format($item->harga_satuan ?? 0, 0, ',', '.') }}
                                        </td>
                                        <td class="text-center">{{ $item->kuantitas ?? 0 }}</td>
                                        <td class="text-end fw-bold text-primary">
                                            Rp {{ number_format($item->subtotal ?? 0, 0, ',', '.') }}
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center text-muted py-4">
                                            Tidak ada item produk dalam transaksi ini.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection