<!-- memanggil file app.blade.php -->
@extends('layouts.app')

<!-- mengirimkan nilai ke title untuk ditampilkan -->
@section('title', 'Dashboard')

<!-- batas awal isi konten -->
@section('content')

@include('layouts.navbar')

<div class="container py-4">
    <!-- Header Dashboard -->
    <div class="d-flex justify-content-between align-items-center mb-4 pb-2 border-bottom">
        <div>
            <h3 class="fw-bold mb-0 text-dark">Ringkasan Hari Ini</h3>
            <small class="text-muted fs-6">{{ $tanggalHariIni->translatedFormat('l, d F Y') }}</small>
        </div>
    </div>

    @can('viewAny', App\Models\User::class)
    <!-- Sub-section 1: Today's Sales -->
    <h5 class="fw-bold text-secondary text-center mb-3">Today's Sales</h5>
    <div class="row g-3 mb-4">
        <div class="col-md-6">
            <div class="card h-100 border-0 shadow-sm">
                <div class="card-body">
                    <span class="text-muted text-uppercase fw-semibold style-caption d-block">Total Penjualan</span>
                    <h4 class="fw-bold text-primary mt-2 mb-0">Rp {{ number_format($ringkasan['total_penjualan']) }}</h4>
                </div>
            </div>
        </div>
        
        <div class="col-md-6">
            <div class="card h-100 border-0 shadow-sm">
                <div class="card-body">
                    <span class="text-muted text-uppercase fw-semibold style-caption d-block">Jumlah Transaksi</span>
                    <h4 class="fw-bold text-dark mt-2 mb-0">{{ $ringkasan['total_transaksi'] }} Transaksi</h4>
                </div>
            </div>
        </div>
    </div>

    <!-- Sub-section 2: Cash & Payment Status -->
    <h5 class="fw-bold text-secondary text-center mb-3">Cash & Payment Status</h5>
    <div class="row g-3 mb-4">
        <div class="col-md-6">
            <div class="card h-100 border-0 shadow-sm">
                <div class="card-body">
                    <span class="text-success text-uppercase fw-semibold style-caption d-block">Pembayaran Tunai</span>
                    <h4 class="fw-bold text-success mt-2 mb-0">Rp {{ number_format($ringkasan['total_cash']) }}</h4>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card h-100 border-0 shadow-sm">
                <div class="card-body">
                    <span class="text-info text-uppercase fw-semibold style-caption d-block">Pembayaran Non-Tunai</span>
                    <h4 class="fw-bold text-info mt-2 mb-0">Rp {{ number_format($ringkasan['total_non_tunai']) }}</h4>
                </div>
            </div>
        </div>
    </div>
    @endcan

    <!-- Section 2: Critical Inventory Status -->
    <h5 class="fw-bold text-secondary text-center mb-3">Critical Inventory Status</h5>
    <div class="row g-4 mb-4">
        <!-- Stok Rendah -->
        <div class="col-md-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white py-3 border-0">
                    <h5 class="fw-bold mb-0 text-warning">Daftar Produk Stok Rendah</h5>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th width="10%" class="ps-3">#</th>
                                    <th>Nama Produk</th>
                                    <th width="20%" class="text-end pe-3">Stok</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($produkStokRendah as $index => $produk)
                                    <tr>
                                        <td class="ps-3">{{ $produkStokRendah->firstItem() + $index }}</td>
                                        <td class="fw-medium">{{ $produk->nama }}</td>
                                        <td class="text-end pe-3">
                                            <span class="badge bg-warning text-dark px-2 py-1">{{ $produk->stok }}</span>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="text-center text-muted py-4">Stok aman</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                @if($produkStokRendah->hasPages())
                <div class="card-footer bg-white border-0 py-2">
                    {{ $produkStokRendah->links() }}
                </div>
                @endif
            </div>
        </div>

        <!-- Stok Habis -->
        <div class="col-md-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white py-3 border-0">
                    <h5 class="fw-bold mb-0 text-danger">Produk Habis Stok</h5>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th width="10%" class="ps-3">#</th>
                                    <th>Nama Produk</th>
                                    <th width="20%" class="text-end pe-3">Stok</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($produkStokHabis as $index => $produk)
                                    <tr>
                                        <td class="ps-3">{{ $produkStokHabis->firstItem() + $index }}</td>
                                        <td class="fw-medium">{{ $produk->nama }}</td>
                                        <td class="text-end pe-3">
                                            <span class="badge bg-danger px-2 py-1">{{ $produk->stok }}</span>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="text-center text-muted py-4">Tidak ada produk habis stok</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                @if($produkStokHabis->hasPages())
                <div class="card-footer bg-white border-0 py-2">
                    {{ $produkStokHabis->links() }}
                </div>
                @endif
            </div>
        </div>
    </div> 
    
    <!-- Section 3: Best Seller Products -->
    <div class="row">
        <div class="col-md-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white py-3 border-0">
                    <h5 class="fw-bold mb-0 text-dark">Produk Terlaris (Best Seller)</h5>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th width="10%" class="ps-3">#</th>
                                    <th>Nama Produk</th>
                                    <th width="20%">Stok Sisa</th>
                                    <th width="20%" class="text-end pe-3">Unit Terjual</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($produkTerlaris as $produk)
                                    <tr>
                                        <td class="ps-3">{{ $loop->iteration }}</td>
                                        <td class="fw-medium">{{ $produk->nama }}</td>
                                        <td><span class="badge bg-danger">{{ $produk->stok }}</span></td>
                                        <td class="text-end pe-3 fw-bold text-success">{{ $produk->total_terjual }} unit</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center text-muted py-4">Belum ada data penjualan produk.</td>
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
<!-- batas Akhir isi konten -->
@endsection