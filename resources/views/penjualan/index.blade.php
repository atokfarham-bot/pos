@extends('layouts.app')

@section('title', 'Penjualan')

@section('content')

@include('layouts.navbar')

<div class="container py-4 px-0">

    {{-- Alert Messages --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if(session('errors'))
        <div class="alert alert-danger alert-dismissible fade show mb-4" role="alert">
            {{ session('errors') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    {{-- Header Page --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold text-dark m-0">Riwayat Penjualan</h2>
            <p class="text-muted small m-0">Pantau seluruh transaksi dan riwayat penjualan sistem POS.</p>
        </div>
        <a href="{{ route('penjualan.create') }}" class="btn btn-primary px-3 font-medium">
            + Tambah Penjualan
        </a>
    </div>

    {{-- Main Content Card --}}
    <div class="card border-0 shadow-sm rounded-3">
        <div class="card-body p-4">
            
            {{-- Form Pencarian --}}
            <form action="{{ route('penjualan.index') }}" method="GET" class="mb-4">
                <div class="row g-2 justify-content-end">
                    <div class="col-md-4">
                        <div class="input-group">
                            <input
                                type="text"
                                name="search"
                                value="{{ request()->search }}"
                                class="form-control"
                                placeholder="Cari transaksi..."
                            >
                            <button class="btn btn-outline-primary" type="submit">
                                Cari
                            </button>
                        </div>
                    </div>
                </div>
            </form>

            {{-- Tabel Penjualan --}}
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th scope="col" class="py-3" style="width: 50px;">#</th>
                            <th scope="col" class="py-3">Tanggal Transaksi</th>
                            <th scope="col" class="py-3">Kasir</th>
                            <th scope="col" class="py-3">Total Pembayaran</th>
                            <th scope="col" class="py-3 text-center">Metode</th>
                            <th scope="col" class="py-3 text-center">Status</th>
                            <th scope="col" class="py-3 text-end" style="width: 180px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($sales as $sale)
                        <tr>
                            <td>{{ $sales->firstItem() + $loop->index }}</td>
                            <td class="text-secondary small">{{ $sale->created_at->translatedFormat('d-m-Y H:i:s') }}</td>
                            <td class="fw-semibold text-dark">{{ $sale->user->name }}</td>
                            <td class="fw-bold text-primary">Rp {{ number_format($sale->total_pembayaran, 0, ',', '.') }}</td>
                            <td class="text-center">
                                <span class="badge bg-secondary-subtle text-secondary border border-secondary-subtle px-2 py-1 uppercase">
                                    {{ $sale->metode_pembayaran }}
                                </span>
                            </td>
                            <td class="text-center">
                                @if(strtoupper($sale->status) == 'COMPLETED' || strtoupper($sale->status) == 'SELESAI')
                                    <span class="badge bg-success-subtle text-success border border-success-subtle px-2 py-1">Completed</span>
                                @elseif(strtoupper($sale->status) == 'PENDING')
                                    <span class="badge bg-warning-subtle text-warning-emphasis border border-warning-subtle px-2 py-1">Pending</span>
                                @else
                                    <span class="badge bg-danger-subtle text-danger border border-danger-subtle px-2 py-1">{{ $sale->status }}</span>
                                @endif
                            </td>
                            <td class="text-end">
                                <div class="d-inline-flex gap-1">
                                    <a href="#" class="btn btn-sm btn-info text-white" title="Detail">
                                        Detail
                                    </a>
                                    @can('view', $sale)
                                        <a href="{{ route('penjualan.edit', $sale) }}" class="btn btn-sm btn-warning text-white" title="Edit">
                                            Edit
                                        </a>
                                    @endcan
                                    @can('delete', $sale)
                                        <form action="{{ route('penjualan.destroy', $sale->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-sm btn-danger" onclick="return confirm('Apakah anda yakin akan menghapus penjualan ini?')" title="Hapus">
                                                Hapus
                                            </button>
                                        </form>
                                    @endcan
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center py-5 text-muted">
                                Data transaksi tidak ditemukan.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Pagination --}}
            @if(method_exists($sales, 'links'))
                <div class="mt-4">
                    {{ $sales->links() }}
                </div>
            @endif

        </div>
    </div>

</div>

@endsection