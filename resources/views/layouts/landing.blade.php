<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>{{ $title ?? 'Elite Rental' }}</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Segoe+UI:wght@400;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="{{ asset('css/landing-page.css') }}">
  {{-- Slot untuk tambahan CSS per halaman --}}
  {{ $styles ?? '' }}
</head>
<body class="d-flex flex-column min-vh-100">

  {{-- NAVBAR — sama di semua halaman landing --}}
  <nav class="navbar navbar-expand-lg navbar-dark bg-custom-primary px-3 px-md-5 py-3">
    <div class="container-fluid">
      <a class="navbar-brand fw-bold fs-4" href="{{ url('/') }}">ELITERENTAL</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
        <ul class="navbar-nav gap-3 align-items-center mt-3 mt-lg-0">
          <li class="nav-item"><a class="nav-link text-white" href="#">Home</a></li>
          <li class="nav-item"><a class="nav-link text-white" href="#">Games</a></li>
          <li class="nav-item"><a class="nav-link text-white me-lg-3" href="#">About</a></li>

          @guest
            <li class="nav-item dropdown">
              <a class="btn btn-light text-custom-primary fw-bold rounded-pill px-4 dropdown-toggle"
                 href="#" role="button" data-bs-toggle="dropdown">
                Masuk / Daftar
              </a>
              <ul class="dropdown-menu dropdown-menu-end">
                <li><a class="dropdown-item" href="{{ route('login') }}"><i class="bi bi-box-arrow-in-right me-2"></i>Login</a></li>
                <li><a class="dropdown-item" href="{{ route('register') }}"><i class="bi bi-person-plus me-2"></i>Register</a></li>
              </ul>
            </li>
          @endguest

          @auth
            <li class="nav-item dropdown">
              <a href="#" class="d-flex align-items-center gap-2 text-decoration-none dropdown-toggle"
                 role="button" data-bs-toggle="dropdown">
                <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center"
                     style="width:36px; height:36px; font-size:14px;">
                  {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                </div>
                <span class="fw-semibold text-light small">{{ Auth::user()->name }}</span>
              </a>
              <ul class="dropdown-menu dropdown-menu-end">
                <li><a class="dropdown-item" href="{{ route('profil.index') }}"><i class="bi bi-person me-2"></i>Profil</a></li>
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
            </li>
          @endauth
        </ul>
      </div>
    </div>
  </nav>

  {{-- KONTEN per halaman masuk di sini --}}
  <div class="flex-grow-1">
    @yield('content')
  </div>

  {{-- FOOTER --}}
  <footer class="bg-custom-primary text-white text-center py-3 mt-5">
    <p class="m-0 small">© 2026 Elite Rental</p>
  </footer>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  {{-- Slot untuk tambahan JS per halaman --}}
  @yield('scripts')
</body>
</html>