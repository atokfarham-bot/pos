<nav class="navbar navbar-expand-lg bg-white border-bottom shadow-sm py-2">
  <!-- Tambahkan px-0 agar padding kiri & kanan navbar hilang dan sejajar presisi -->
  <div class="container px-0">

    <a class="navbar-brand fw-bold text-primary fs-4 ps-0" href="#">POS</a>

    <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse"
      data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" 
      aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link px-3 {{ Request::is('dashboard') ? 'active text-primary fw-bold' : 'text-dark fw-semibold' }}" aria-current="page" href="{{ route('dashboard') }}">Dashboard</a>
        </li>
        <li class="nav-item">
          <a class="nav-link px-3 {{ Request::is('admin/users') ? 'active text-primary fw-bold' : 'text-dark fw-semibold' }}" href="{{ route('admin.users') }}">Users</a>
        </li>
        <li class="nav-item">
          <a class="nav-link px-3 {{ Request::is('jenis') ? 'active text-primary fw-bold' : 'text-dark fw-semibold' }}" href="{{ route('jenis.index') }}">Jenis</a>
        </li>
       
        <li class="nav-item">
          <a class="nav-link px-3 {{ Request::is('produk') ? 'active text-primary fw-bold' : 'text-dark fw-semibold' }}" href="{{ route('produk.index') }}">Produk</a>
        </li>
        <li class="nav-item">
          <a class="nav-link px-3 {{ Request::is('penjualan') ? 'active text-primary fw-bold' : 'text-dark fw-semibold' }}" href="{{ route('penjualan.index') }}">Penjualan</a>
        </li>
      </ul>

      <!-- Logout -->
      <form action="{{ route('logout') }}" method="POST" class="d-flex me-0">
        @csrf
        <button type="submit" class="btn btn-danger px-3 fw-medium">Logout</button>
      </form>
    </div>

  </div>
</nav>