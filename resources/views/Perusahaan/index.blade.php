@extends('layouts.app')

@section('content')
<div class="container py-4">
    <h2 class="fw-bold mb-1">Data Perusahaan</h2>
    <p class="text-muted mb-4">Kelola informasi profil perusahaan Anda</p>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card shadow-sm">
        <div class="card-body p-4">
            <form action="{{ route('perusahaan.update') }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label class="form-label fw-semibold">Nama Perusahaan</label>
                    <input type="text" name="nama" class="form-control" value="{{ old('nama', $perusahaan->nama ?? '') }}" required>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">Alamat</label>
                    <textarea name="alamat" class="form-control" rows="3">{{ old('alamat', $perusahaan->alamat ?? '') }}</textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">Nomor Telepon</label>
                    <input type="text" name="telepon" class="form-control" value="{{ old('telepon', $perusahaan->telepon ?? '') }}">
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">Email</label>
                    <input type="email" name="email" class="form-control" value="{{ old('email', $perusahaan->email ?? '') }}">
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">NPWP</label>
                    <input type="text" name="npwp" class="form-control" value="{{ old('npwp', $perusahaan->npwp ?? '') }}">
                </div>

                <button type="submit" class="btn btn-primary px-4 fw-semibold">Simpan</button>
            </form>
        </div>
    </div>
</div>
@endsection