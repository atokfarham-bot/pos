<!-- memanggil file app.blade.php -->
@extends('layouts.app')

<!-- mengirimkan nilai ke title untuk ditampilkan -->
@section('title', 'Dashboard')

<!-- batas awal isi konten -->
@section('content')

    @include('layouts.navbar')
    <div class="container my-5">

        {{-- Header --}}
        <div class="text-center mb-5">
            <h1 class="fw-bold">Tentang Kami</h1>
        </div>

        {{-- Deskripsi Perusahaan --}}
        <div class="row mb-5">
            <div class="col-md-8 mx-auto">
                 <h3 class="mb-3 text-center">Profil Perusahaan</h3>
                <img src="images/logo.png" 
                             alt="Zahra Fashion" 
                             class="rounded-circle img-thumbnail mb-3 d-block mx-auto" 
                             style="width: 150px; height: 150px; object-fit: cover;" />
               
                <p>
                    Nyam-Chicken Series adalah perusahaan yang bergerak di bidang
                    bidang usaha, misalnya: retail dan penjualan makanan kebutuhan sehari-hari
                    sejak tahun 2024. Kami berkomitmen untuk memberikan pelayanan
                    terbaik kepada setiap pelanggan dengan mengutamakan kualitas produk,
                    kecepatan transaksi, dan kepuasan pelanggan.
                </p>
                <p>
                    Dengan sistem Point of Sale (POS) yang kami kembangkan, kami memastikan
                    setiap proses transaksi berjalan cepat, akurat, dan transparan.
                </p>
            </div>
        </div>

        {{-- Visi & Misi --}}
        <div class="row mb-5">
            <div class="col-md-6 mb-4">
                <div class="card h-100 shadow-sm">
                    <div class="card-body">
                        <h4 class="card-title">Visi</h4>
                        <p class="card-text">
                            Menjadi perusahaan terdepan dalam bidang usaha yang terpercaya
                            dan memberikan nilai tambah bagi masyarakat.
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-md-6 mb-4">
                <div class="card h-100 shadow-sm">
                    <div class="card-body">
                        <h4 class="card-title">Misi</h4>
                        <ul class="mb-0">
                            <li>Memberikan pelayanan terbaik kepada pelanggan</li>
                            <li>Menjaga kualitas produk dan layanan</li>
                            <li>Mengembangkan sistem yang efisien dan transparan</li>
                            <li>Membangun kepercayaan jangka panjang dengan pelanggan</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        {{-- Layanan Kami --}}
        <div class="mb-5">
            <h3 class="text-center mb-4">Layanan Kami</h3>
            <div class="row">
                <div class="col-md-4 mb-4 text-center">
                    <div class="p-4 border rounded h-100">
                        <h5>Penjualan Produk</h5>
                        <p class="text-muted mb-0">
                            Menyediakan berbagai produk berkualitas dengan harga bersaing.
                        </p>
                    </div>
                </div>
                <div class="col-md-4 mb-4 text-center">
                    <div class="p-4 border rounded h-100">
                        <h5>Transaksi Cepat</h5>
                        <p class="text-muted mb-0">
                            Sistem kasir digital yang memudahkan proses transaksi dan pembayaran.
                        </p>
                    </div>
                </div>
                <div class="col-md-4 mb-4 text-center">
                    <div class="p-4 border rounded h-100">
                        <h5>Layanan Pelanggan</h5>
                        <p class="text-muted mb-0">
                            Tim kami siap membantu menjawab pertanyaan dan keluhan Anda.
                        </p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Alamat & Kontak --}}
        <div class="row">
            <div class="col-md-6 mb-4">
                <h4 class="mb-3">Alamat</h4>
                <p>
                    Nyam-Chicken Series<br>
                    Jl. Golempang 15. 085860201095<br>
                    Kelurahan Sukamenak, Kecamatan Purbaratu<br>
                    Kota Tasikmalaya, Provinsi Jawa Barat, Kode Pos 33366,<br>
                    Indonesia
                </p>
            </div>
            <div class="col-md-6 mb-4">
                <h4 class="mb-3">Kontak Kami</h4>
                <ul class="list-unstyled">
                    <li class="mb-2">
                        <strong>Telepon:</strong> 085860201095
                    </li>
                    <li class="mb-2">
                        <strong>WhatsApp:</strong> 085860201095
                    </li>
                    <li class="mb-2">
                        <strong>Email:</strong> atokfarham@gmail.com
                    </li>
                    <li class="mb-2">
                        <strong>Jam Operasional:</strong> Senin - Sabtu, 08.00 - 20.00 WIB
                    </li>
                </ul>
            </div>
        </div>

        {{-- Peta (opsional) --}}
        <div class="mt-4">
            <h4 class="mb-3">Lokasi Kami</h4>
            <div class="ratio ratio-16x9">
                <iframe src="https://www.google.com/maps/embed?pb=[GANTI_DENGAN_EMBED_LINK_MAPS_ANDA]" style="border:0;"
                    allowfullscreen loading="lazy">
                </iframe>
            </div>
        </div>

    </div>
@endsection
