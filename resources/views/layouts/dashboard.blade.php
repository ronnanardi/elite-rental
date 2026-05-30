<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>{{ $title ?? 'Dashboard - Elite Rental' }}</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
  <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
  @yield('styles')
  <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body>

{{-- MOBILE HEADER --}}
<header class="navbar navbar-dark bg-dark d-md-none px-3 py-2">
  <a class="navbar-brand fw-bold" href="#">ELITERENTAL</a>
  <button class="navbar-toggler" type="button"
          data-bs-toggle="collapse" data-bs-target="#sidebarMenu">
    <span class="navbar-toggler-icon"></span>
  </button>
</header>

<div class="container-fluid">
  <div class="row">

    {{-- SIDEBAR --}}
    <nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block sidebar collapse p-3">
      <div class="brand my-3 px-2 d-none d-md-block">ELITERENTAL</div>
      <div class="menu-header px-2 mt-4 mb-2">MENU</div>
      <ul class="nav flex-column">
        <li class="nav-item">
          <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">
            Konfirmasi
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link {{ request()->routeIs('admin.aktivasi') ? 'active' : '' }}" href="{{ route('admin.aktivasi') }}">
            Aktivasi
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link {{ request()->routeIs('admin.bermain') ? 'active' : '' }}" href="{{ route('admin.bermain') }}">
            Bermain
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link {{ request()->routeIs('admin.riwayat') ? 'active' : '' }}" href="{{ route('admin.riwayat') }}">
            Riwayat
          </a>
        </li>
      </ul>
    </nav>

    {{-- MAIN --}}
    <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 pt-3">
      
      {{-- TOPBAR --}}
      <div class="d-flex justify-content-between align-items-center flex-wrap flex-md-nowrap mb-4 bg-white p-3 rounded shadow-sm">
        <div class="w-50">
          <input type="text" class="form-control form-control-sm border-0 bg-light"
                 placeholder="Type to search..." style="max-width: 300px;">
        </div>
        <div class="d-flex align-items-center gap-3">
          <button class="btn btn-light btn-sm text-warning bg-warning-subtle border-0">
            <i class="bi bi-bell-fill"></i>
          </button>
          <button class="btn btn-light btn-sm text-primary bg-primary-subtle border-0">
            <i class="bi bi-envelope-fill"></i>
          </button>
          <div class="dropdown">
            <a href="#" class="d-flex align-items-center gap-2 text-decoration-none dropdown-toggle"
               role="button" data-bs-toggle="dropdown">
              <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center"
                   style="width:34px; height:34px; font-size:13px;">
                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
              </div>
              <span class="fw-semibold text-secondary small">Admin {{ Auth::user()->name }}</span>
            </a>
            <ul class="dropdown-menu dropdown-menu-end">
              <li><a class="dropdown-item" href="#"><i class="bi bi-person me-2"></i>Profil</a></li>
              <li><hr class="dropdown-divider"></li>
              <li>
                <form method="POST" action="{{ route('logout') }}">
                  @csrf
                  <button type="submit" class="dropdown-item text-danger">
                    <i class="bi bi-box-arrow-right me-2"></i>Logout
                  </button>
                </form>
              </li>
            </ul>
          </div>
        </div>
      </div>

      {{-- Stat cards: tampil default, bisa disembunyikan per halaman --}}
      @yield('stat_cards', View::make('admin.partials.stat-cards', [
          'totalKonfirmasi' => \App\Models\Rental::where('status','waiting_confirmation')->count(),
          'totalAktivasi'   => \App\Models\Rental::where('status','approved')->count(),
          'totalBermain'    => \App\Models\Rental::where('status','active')->count(),
          'totalSelesai'    => \App\Models\Rental::where('status','done')->count(),
          'totalDitolak'    => \App\Models\Rental::where('status','rejected')->count(),
      ]))

      {{-- KONTEN per halaman masuk di sini --}}
      @yield('content')

    </main>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
@yield('scripts')
</body>
</html>