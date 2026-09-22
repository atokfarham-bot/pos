@extends('layouts.app')

@section('title', 'Produk')

@section('content')

@include('layouts.navbar')

<div class="container py-4 px-0">


    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show mb-4" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    {{-- Header Page --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold text-dark m-0">Daftar Produk</h2>
            <p class="text-muted small m-0">Kelola item, stok, dan harga jual produk POS Anda.</p>
        </div>
        @can('create', App\Models\Produk::class)
            <a href="{{ route('produk.create') }}" class="btn btn-primary px-3 font-medium">
                + Tambah Produk
            </a>
        @endcan
    </div>

    {{-- Main Content Card --}}
    <div class="card border-0 shadow-sm rounded-3">
        <div class="card-body p-4">
            
            {{-- Form Pencarian --}}
            <form action="{{ route('produk.index') }}" method="GET" class="mb-4">
                <div class="row g-2 justify-content-end">
                    <div class="col-md-4">
                        <div class="input-group">
                            <input
                                type="text"
                                name="search"
                                value="{{ request('search') }}"
                                class="form-control"
                                placeholder="Cari nama produk..."
                            >
                            <button class="btn btn-outline-primary" type="submit">
                                Cari
                            </button>
                        </div>
                    </div>
                </div>
            </form>

            {{-- Tabel Produk --}}
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th scope="col" class="py-3" style="width: 50px;">#</th>
                            <th scope="col" class="py-3" style="width: 80px;">Foto</th>
                            <th scope="col" class="py-3">Nama Produk</th>
                            <th scope="col" class="py-3">Jenis Produk</th> {{-- 💡 1. Tambah Header Kolom Jenis --}}
                            <th scope="col" class="py-3">Dibuat Oleh</th>
                            <th scope="col" class="py-3">Harga Beli</th>
                            <th scope="col" class="py-3">Harga Jual</th>
                            <th scope="col" class="py-3 text-center">Stok</th>
                 
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($products as $product)
                        <tr>
                            <td>{{ $products->firstItem() + $loop->index }}</td>
                            <td>
                                @if ($product->foto && \Storage::disk('public')->exists($product->foto))
                                    <img src="{{ asset('storage/' . $product->foto) }}"
                                         width="50"
                                         height="50"
                                         class="rounded object-fit-cover border"
                                         alt="{{ $product->nama }}">
                                @else
                                    <img src="https://placehold.co/50x50?text=No+Img"
                                         width="50"
                                         height="50"
                                         class="rounded object-fit-cover border"
                                         alt="No Image">
                                @endif
                            </td>
                            <td class="fw-semibold text-dark">{{ $product->nama }}</td>
                            
                            {{-- 💡 2. Tambah Data Kolom Jenis --}}
                            <td>
                                <span class="badge bg-secondary-subtle text-secondary border border-secondary-subtle px-2 py-1 small">
                                    {{ $product->jenis?->nama_jenis ?? 'Tanpa Jenis' }}
                                </span>
                            </td>

                            <td class="text-secondary small">{{ $product->user?->name ?? '-' }}</td>
                            <td class="text-muted">Rp {{ number_format($product->harga_Beli, 0, ',', '.') }}</td>
                            <td class="fw-semibold text-success">Rp {{ number_format($product->harga_jual, 0, ',', '.') }}</td>
                            <td class="text-center">
                                @if($product->stok <= 5)
                                    <span class="badge bg-danger-subtle text-danger border border-danger-subtle px-2 py-1">{{ $product->stok }}</span>
                                @elseif($product->stok <= 20)
                                    <span class="badge bg-warning-subtle text-warning-emphasis border border-warning-subtle px-2 py-1">{{ $product->stok }}</span>
                                @else
                                    <span class="badge bg-success-subtle text-success border border-success-subtle px-2 py-1">{{ $product->stok }}</span>
                                @endif
                            </td>
                            <td class="text-end">
                                <div class="d-inline-flex gap-1">
                                    @can('update', $product)
                                        <a href="{{ route('produk.edit', $product) }}" class="btn btn-sm btn-warning text-white" title="Edit">
                                            Edit
                                        </a>
                                    @endcan
                                    @can('delete', $product)
                                        <form action="{{ route('produk.destroy', $product) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-sm btn-danger" onclick="return confirm('Apakah anda yakin akan menghapus produk ini?')" title="Hapus">
                                                Hapus
                                            </button>
                                        </form>
                                    @endcan
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            {{-- 💡 3. colspan diubah dari 8 menjadi 9 karena jumlah kolom bertambah --}}
                            <td colspan="9" class="text-center py-5 text-muted">
                                Tidak ada data produk ditemukan.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Pagination --}}
            @if(method_exists($products, 'links'))
                <div class="mt-4">
                    {{ $products->links() }}
                </div>
            @endif

        </div>
    </div>

</div>

@endsection
