@extends('layouts.app')

@section('title', 'Users')

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
    <div class="d-flex justify-content-between items-center align-items-center mb-4">
        <div>
            <h2 class="fw-bold text-dark m-0">Daftar Pengguna</h2>
            <p class="text-muted small m-0">Kelola data pengguna sistem POS Anda di sini.</p>
        </div>
        <a href="{{ route('admin.users.create') }}" class="btn btn-primary px-3 font-medium">
            + Tambah Pengguna
        </a>
    </div>

    {{-- Main Content Card --}}
    <div class="card border-0 shadow-sm rounded-3">
        <div class="card-body p-4">
            
            {{-- Form Pencarian --}}
            <form action="{{ route('admin.users') }}" method="GET" class="mb-4">
                <div class="row g-2 justify-content-end">
                    <div class="col-md-4">
                        <div class="input-group">
                            <input
                                type="text"
                                name="search"
                                value="{{ request('search') }}"
                                class="form-control"
                                placeholder="Cari nama atau email..."
                            >
                            <button class="btn btn-outline-primary" type="submit">
                                Cari
                            </button>
                        </div>
                    </div>
                </div>
            </form>

            {{-- Tabel User --}}
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th scope="col" class="py-3" style="width: 50px;">#</th>
                            <th scope="col" class="py-3">Nama</th>
                            <th scope="col" class="py-3">Email</th>
                            <th scope="col" class="py-3">Pengguna</th>
                            <th scope="col" class="py-3 text-end" style="width: 150px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($users as $user)
                        <tr>
                            <td>{{ $users->firstItem() + $loop->index }}</td>
                            <td class="fw-semibold text-dark">{{ $user->name }}</td>
                            <td class="text-secondary">{{ $user->email }}</td>
                            <td>
                                @if($user->role->name == 'admin')
                                    <span class="badge bg-primary-subtle text-primary border border-primary-subtle px-2 py-1">admin</span>
                                @else
                                    <span class="badge bg-warning-subtle text-warning-emphasis border border-warning-subtle px-2 py-1">kasir</span>
                                @endif
                            </td>
                            <td class="text-end">
                                <div class="d-inline-flex gap-1">
                                    <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-sm btn-warning text-white" title="Edit">
                                        Edit
                                    </a>
                                    <form action="{{ route('admin.users.destroy', $user) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-danger" onclick="return confirm('Yakin hapus Pengguna ini?')" title="Hapus">
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center py-4 text-muted">
                                Tidak ada data Pengguna ditemukan.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Link Pagination jika ada --}}
            @if(method_exists($users, 'links'))
                <div class="mt-4">
                    {{ $users->links() }}
                </div>
            @endif

        </div>
    </div>

</div>

@endsection