<!-- memanggil file app.blade.php -->
@extends('layouts.app')

<!-- mengirimkan nilai ke title untuk ditampilkan -->
@section('title', 'Login - POS System')

<!-- batas awal isi konten -->
@section('content')

<div class="bg-light min-vh-100 w-100 d-flex align-items-center justify-content-center py-5 overflow-hidden">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12 col-sm-9 col-md-7 col-lg-4">
                
                {{-- Card Box Login --}}
                <div class="card border-0 shadow-sm rounded-4 p-4 bg-white">
                    <div class="card-body">
                        
                        {{-- Header / Icon Branding --}}
                        <div class="text-center mb-4">
                            <div class="bg-primary bg-opacity-10 text-primary d-inline-flex align-items-center justify-content-center rounded-circle mb-3" style="width: 60px; height: 60px;">
                                <i class="bi bi-box-seam fs-3"></i>
                            </div>
                            <h4 class="fw-bold text-dark mb-1">Login POS</h4>
                            <p class="text-muted small">Masuk untuk mengakses sistem kasir</p>
                        </div>

                        {{-- Form Login --}}
                        <form action="{{ route('auth') }}" method="POST">
                            @csrf

                            <!-- Email Input -->
                            <div class="mb-3 text-start">
                                <label for="exampleInputEmail1" class="form-label small fw-semibold text-secondary">Email address</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0 rounded-start-3 text-muted">
                                        <i class="bi bi-envelope"></i>
                                    </span>
                                    <input type="email" name="email" class="form-control bg-light border-start-0 rounded-end-3 @error('email') is-invalid @enderror" id="exampleInputEmail1" value="{{ old('email') }}" placeholder="nama@email.com" autofocus required>
                                </div>
                                @error('email')
                                    <div class="text-danger small mt-1">
                                        <i class="bi bi-exclamation-circle me-1"></i>{{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <!-- Password Input -->
                            <div class="mb-4 text-start">
                                <label for="exampleInputPassword1" class="form-label small fw-semibold text-secondary">Password</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0 rounded-start-3 text-muted">
                                        <i class="bi bi-lock"></i>
                                    </span>
                                    <input type="password" name="password" class="form-control bg-light border-start-0 rounded-end-3 @error('password') is-invalid @enderror" id="exampleInputPassword1" placeholder="••••••••" required>
                                </div>
                                @error('password')
                                    <div class="text-danger small mt-1">
                                        <i class="bi bi-exclamation-circle me-1"></i>{{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <!-- Submit Button -->
                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary rounded-3 py-2 fw-semibold">
                                    Masuk
                                </button>
                            </div>

                        </form>

                    </div>
                </div>

                {{-- Footer Text --}}
                <div class="text-center mt-4">
                    <p class="text-muted small mb-0">&copy; {{ date('Y') }} POS System. All rights reserved.</p>
                </div>

            </div>
        </div>
    </div>
</div>

<!-- batas akhir isi konten -->
@endsection