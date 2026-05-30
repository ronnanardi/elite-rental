@extends('layouts.landing')

@section('content')
<div class="container my-5" style="max-width: 860px;">

    <h4 class="fw-bold mb-4">Profil Saya</h4>

    <div class="row g-4">

        {{-- Card Profil --}}
        <div class="col-md-4">
            <div class="card border-0 shadow-sm rounded-4 p-4 text-center">

                {{-- Avatar --}}
                <div class="rounded-circle bg-primary text-white d-inline-flex align-items-center 
                            justify-content-center mx-auto mb-3"
                     style="width: 80px; height: 80px; font-size: 2rem;">
                    {{ strtoupper(substr($user->name, 0, 1)) }}
                </div>

                <h5 class="fw-bold mb-1">{{ $user->name }}</h5>
                <p class="text-muted small mb-3">{{ $user->email }}</p>

                <span class="badge bg-primary-subtle text-primary rounded-pill px-3 py-2 mb-4">
                    Member
                </span>

                <div class="text-start border-top pt-3">
                    <p class="text-muted small mb-1">Nama</p>
                    <p class="fw-semibold mb-3">{{ $user->name }}</p>

                    <p class="text-muted small mb-1">Email</p>
                    <p class="fw-semibold mb-3">{{ $user->email }}</p>

                    <p class="text-muted small mb-1">Bergabung Sejak</p>
                    <p class="fw-semibold mb-0">{{ $user->created_at->format('d M Y') }}</p>
                </div>
            </div>
        </div>

        {{-- Kanan --}}
        <div class="col-md-8">

            {{-- Statistik --}}
            <div class="row g-3 mb-4">
                <div class="col-3">
                    <div class="card border-0 shadow-sm rounded-4 p-3 text-center">
                        <h3 class="fw-bold text-primary mb-0">{{ $totalSewa }}</h3>
                        <small class="text-muted">Total Sewa</small>
                    </div>
                </div>
                <div class="col-3">
                    <div class="card border-0 shadow-sm rounded-4 p-3 text-center">
                        <h3 class="fw-bold text-success mb-0">{{ $totalBermain }}</h3>
                        <small class="text-muted">Selesai</small>
                    </div>
                </div>
                <div class="col-3">
                    <div class="card border-0 shadow-sm rounded-4 p-3 text-center">
                        <h3 class="fw-bold text-warning mb-0">{{ $totalBelum }}</h3>
                        <small class="text-muted">Aktif</small>
                    </div>
                </div>
                <div class="col-3">
                    <div class="card border-0 shadow-sm rounded-4 p-3 text-center">
                        <h3 class="fw-bold text-danger mb-0">{{ $totalDitolak }}</h3>
                        <small class="text-muted">Ditolak</small>
                    </div>
                </div>
            </div>

            {{-- Navigasi --}}
            <div class="card border-0 shadow-sm rounded-4 p-3">
                <a href="{{ route('profil.history') }}" 
                   class="d-flex align-items-center justify-content-between p-3 rounded-3 text-decoration-none hover-bg">
                    <div class="d-flex align-items-center gap-3">
                        <div class="rounded-circle bg-primary-subtle text-primary d-flex align-items-center 
                                    justify-content-center" style="width:40px; height:40px;">
                            <i class="bi bi-clock-history"></i>
                        </div>
                        <div>
                            <p class="fw-semibold mb-0 text-dark">History Rental</p>
                            <small class="text-muted">Lihat semua riwayat sewa</small>
                        </div>
                    </div>
                    <i class="bi bi-chevron-right text-muted"></i>
                </a>
            </div>

        </div>
    </div>
</div>
@endsection