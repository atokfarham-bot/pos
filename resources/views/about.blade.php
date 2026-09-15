@extends('layouts.app') {{-- sesuaikan dengan layout utama kamu --}}

@section('content')
<div class="container my-5">

    {{-- Header --}}
    <div class="text-center mb-5">
        <h1 class="fw-bold">Tentang Kami</h1>
        <p class="text-muted">Mengenal lebih dekat [Nama Perusahaan Anda]</p>
    </div>

    {{-- Deskripsi Perusahaan --}}
    <div class="row mb-5">
        <div class="col-md-8 mx-auto">
            <h3 class="mb-3">Profil Perusahaan</h3>
            <p>
                [Nama Perusahaan Anda] adalah perusahaan yang bergerak di bidang
                [bidang usaha, misalnya: retail dan penjualan barang kebutuhan sehari-hari]
                sejak tahun [tahun berdiri]. Kami berkomitmen untuk memberikan pelayanan
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
                        Menjadi perusahaan terdepan dalam [bidang usaha] yang terpercaya
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
                [Nama Perusahaan Anda]<br>
                Jl. [Nama Jalan] No. [Nomor]<br>
                [Kelurahan, Kecamatan]<br>
                [Kota/Kabupaten], [Provinsi] [Kode Pos]<br>
                Indonesia
            </p>
        </div>
        <div class="col-md-6 mb-4">
            <h4 class="mb-3">Kontak Kami</h4>
            <ul class="list-unstyled">
                <li class="mb-2">
                    <strong>Telepon:</strong> [Nomor Telepon, mis. (021) 1234-5678]
                </li>
                <li class="mb-2">
                    <strong>WhatsApp:</strong> [Nomor WhatsApp]
                </li>
                <li class="mb-2">
                    <strong>Email:</strong> [email@perusahaan.com]
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
            <iframe
                src="https://www.google.com/maps/embed?pb=[GANTI_DENGAN_EMBED_LINK_MAPS_ANDA]"
                style="border:0;" allowfullscreen loading="lazy">
            </iframe>
        </div>
    </div>

</div>
@endsection