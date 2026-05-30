@extends('layouts.landing')

@section('content')
<div class="container my-5 d-flex justify-content-center">
    <div class="card border-0 shadow-sm rounded-4 p-5 text-center" style="max-width: 480px; width: 100%;">

        {{-- Icon Centang --}}
        <div class="mb-4">
            <div class="rounded-circle bg-success d-inline-flex align-items-center justify-content-center"
                 style="width: 90px; height: 90px;">
                <i class="bi bi-check-lg text-white" style="font-size: 3rem;"></i>
            </div>
        </div>

        {{-- Judul --}}
        <h4 class="fw-bold mb-1">Bukti Berhasil Diupload!</h4>
        <p class="text-muted small mb-4">Menunggu konfirmasi dari admin.</p>

        {{-- Rincian --}}
        @php
            $data  = session('berhasil');
            $jam   = intdiv($data['durasi'], 60);
            $menit = $data['durasi'] % 60;
        @endphp

        <div class="bg-light rounded-3 p-3 mb-4 text-start">
            <div class="d-flex justify-content-between mb-2">
                <span class="text-muted small">Konsol</span>
                <span class="fw-semibold small">{{ $data['konsol'] }}</span>
            </div>
            <div class="d-flex justify-content-between mb-2">
                <span class="text-muted small">Durasi</span>
                <span class="fw-semibold small">
                    {{ $jam > 0 ? $jam . ' Jam ' : '' }}{{ $menit > 0 ? $menit . ' Menit' : '' }}
                </span>
            </div>
            <hr class="my-2">
            <div class="d-flex justify-content-between">
                <span class="text-muted small">Total Dibayar</span>
                <span class="fw-bold text-success">
                    IDR {{ number_format($data['total'], 0, ',', '.') }}
                </span>
            </div>
        </div>

        {{-- Keterangan --}}
        <p class="text-muted small mb-4">
            Admin akan mengkonfirmasi pembayaran kamu. 
            Pantau status di 
            <a href="{{ route('profil.history') }}" class="text-primary fw-semibold text-decoration-none">
                History Rental
            </a>.
        </p>

        {{-- Tombol --}}
        <a href="{{ route('profil.history') }}" class="btn btn-primary rounded-pill w-100 py-2 fw-semibold mb-2">
            Cek History
        </a>
        <a href="/" class="btn btn-outline-secondary rounded-pill w-100 py-2">
            Kembali ke Beranda
        </a>

    </div>
</div>
@endsection