{{-- <!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ELITERENTAL Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">

</head>
<body>

<header class="navbar navbar-dark bg-dark d-md-none px-3 py-2">
    <a class="navbar-brand fw-bold" href="#">ELITERENTAL</a>
    <button class="navbar-toggler" type="button" 
            data-bs-toggle="collapse" data-bs-target="#sidebarMenu" 
            aria-controls="sidebarMenu" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
</header>

<div class="container-fluid">
    <div class="row">
        <nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block sidebar collapse p-3">
            <div class="brand my-3 px-2 d-none d-md-block">ELITERENTAL</div>
            
            <div class="menu-header px-2 mt-4 mb-2">MENU</div>
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a class="nav-link active" href="#">Konfirmasi</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Aktivasi</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Bermain</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Riwayat</a>
                </li>
            </ul>
        </nav>

        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 pt-3">
            
            <div class="d-flex justify-content-between align-items-center flex-wrap flex-md-nowrap mb-4 bg-white p-3 rounded shadow-sm">
                <div class="w-50">
                    <input type="text" class="form-control form-control-sm border-0 bg-light" placeholder="Type to search..." style="max-width: 300px;">
                </div>
                <div class="d-flex align-items-center gap-3">
                    <button class="btn btn-light btn-sm position-relative text-warning bg-warning-subtle border-0">
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
                            <li>
                                <a class="dropdown-item" href="#">
                                    <i class="bi bi-person me-2"></i>Profil
                                </a>
                            </li>
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
            </div> --}}

        @extends('layouts.dashboard')
        @section('content')

            <div class="row g-3 mb-4">
                <div class="col-12 col-sm-6 col-xl-3">
                    <div class="card stat-card p-3 bg-white">
                        <div class="icon-box bg-light text-secondary mb-2">
                            <i class="bi bi-hourglass-split"></i>
                        </div>
                        <h3 class="fw-bold m-0">17</h3>
                        <small class="text-muted">Pelanggan Konfirmasi</small>
                    </div>
                </div>
                <div class="col-12 col-sm-6 col-xl-3">
                    <div class="card stat-card p-3 bg-white">
                        <div class="icon-box bg-success-subtle text-success mb-2">
                            <i class="bi bi-check-circle-fill"></i>
                        </div>
                        <h3 class="fw-bold m-0">8</h3>
                        <small class="text-muted">Pelanggan Aktivasi</small>
                    </div>
                </div>
                <div class="col-12 col-sm-6 col-xl-3">
                    <div class="card stat-card p-3 bg-white">
                        <div class="icon-box bg-light text-dark mb-2">
                            <i class="bi bi-controller"></i>
                        </div>
                        <h3 class="fw-bold m-0">5</h3>
                        <small class="text-muted">Pelanggan Bermain</small>
                    </div>
                </div>
                <div class="col-12 col-sm-6 col-xl-3">
                    <div class="card stat-card p-3 bg-white">
                        <div class="icon-box bg-light text-secondary mb-2">
                            <i class="bi bi-credit-card-2-back"></i>
                        </div>
                        <h3 class="fw-bold m-0"><span class="text-success">45</span> <span class="text-muted">/</span> <span class="text-danger">03</span></h3>
                        <small class="text-muted">Transaksi</small>
                    </div>
                </div>
            </div>

            <div class="card main-content-card bg-white p-4 mb-4">
                <h6 class="fw-bold mb-4" style="color: #1e2530;">Konfirmasi Pembayaran</h6>
                
                <div class="table-responsive">
                    <table class="table table-borderless align-middle m-0">
                        <thead>
                            <tr>
                                <th style="width: 80px;">No</th>
                                <th>Name</th>
                                <th>Tanggal</th>
                                <th style="min-width: 280px;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="text-muted">01</td>
                                <td class="fw-semibold">Budi Setiawan</td>
                                <td class="text-muted">04 Mei 2026</td>
                                <td>
                                    <div class="d-flex gap-1">
                                        <button class="btn btn-sm btn-custom-blue py-1 px-2 small">Lihat Gambar</button>
                                        <button class="btn btn-sm btn-custom-yellow py-1 px-2 small">Chat</button>
                                        <button class="btn btn-sm btn-custom-green py-1 px-2 small">Terima</button>
                                        <button class="btn btn-sm btn-custom-red py-1 px-2 small">Tolak</button>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td class="text-muted">02</td>
                                <td class="fw-semibold">Santi Wijaya</td>
                                <td class="text-muted">04 Mei 2026</td>
                                <td>
                                    <div class="d-flex gap-1">
                                        <button class="btn btn-sm btn-custom-blue py-1 px-2 small">Lihat Gambar</button>
                                        <button class="btn btn-sm btn-custom-yellow py-1 px-2 small">Chat</button>
                                        <button class="btn btn-sm btn-custom-green py-1 px-2 small">Terima</button>
                                        <button class="btn btn-sm btn-custom-red py-1 px-2 small">Tolak</button>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td class="text-muted">03</td>
                                <td class="fw-semibold">Andi Pratama</td>
                                <td class="text-muted">03 Mei 2026</td>
                                <td>
                                    <div class="d-flex gap-1">
                                        <button class="btn btn-sm btn-custom-blue py-1 px-2 small">Lihat Gambar</button>
                                        <button class="btn btn-sm btn-custom-yellow py-1 px-2 small">Chat</button>
                                        <button class="btn btn-sm btn-custom-green py-1 px-2 small">Terima</button>
                                        <button class="btn btn-sm btn-custom-red py-1 px-2 small">Tolak</button>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        @endsection
        {{-- </main>
    </div>
</div> --}}

{{-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html> --}}