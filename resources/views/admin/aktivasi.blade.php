@extends('layouts.dashboard')

@section('content')

@if(session('success'))
    <div class="alert alert-success rounded-3 small py-2 mb-3">{{ session('success') }}</div>
@endif

@if($errors->any())
    <div class="alert alert-danger rounded-3 small py-2 mb-3">{{ $errors->first() }}</div>
@endif

{{-- Input Kode --}}
<div class="card bg-white p-3 mb-4">
    <form method="POST" action="{{ route('admin.input-kode') }}" class="d-flex align-items-center gap-2 flex-wrap">
        @csrf
        <span class="fw-semibold small text-secondary me-1">Input Kode:</span>
        <input type="text"
               name="kode"
               class="form-control form-control-sm text-center fw-bold @error('kode') is-invalid @enderror"
               placeholder="-----"
               maxlength="5"
               style="width: 90px; letter-spacing: 4px;"
               autocomplete="off"
               required>
        <button type="submit" class="btn btn-primary btn-sm px-3">
            Aktifkan
        </button>
        @error('kode')
            <span class="text-danger small">{{ $message }}</span>
        @enderror
    </form>
</div>

{{-- Tabel Menunggu Aktivasi --}}
<div class="card main-content-card bg-white p-4 mb-4">
    <h6 class="fw-bold mb-4" style="color: #1e2530;">Menunggu Aktivasi</h6>

    <div class="table-responsive">
        <table class="table table-borderless align-middle m-0">
            <thead>
                <tr>
                    <th style="width: 60px;">No</th>
                    <th>Nama</th>
                    <th>Konsol</th>
                    <th>Durasi</th>
                    <th>Total</th>
                    <th>Kode</th>
                    <th>Disetujui</th>
                </tr>
            </thead>
            <tbody>
                @forelse($menunggu as $i => $rental)
                @php
                    $jam   = intdiv($rental->duration_minutes, 60);
                    $menit = $rental->duration_minutes % 60;
                @endphp
                <tr>
                    <td class="text-muted">{{ str_pad($i + 1, 2, '0', STR_PAD_LEFT) }}</td>
                    <td class="fw-semibold">{{ $rental->user->name }}</td>
                    <td>{{ $rental->unit->console_type }}</td>
                    <td class="small">
                        {{ $jam > 0 ? $jam . 'j ' : '' }}{{ $menit > 0 ? $menit . 'm' : '' }}
                    </td>
                    <td class="small fw-semibold">
                        IDR {{ number_format($rental->total_price, 0, ',', '.') }}
                    </td>
                    <td>
                        <span class="badge bg-success-subtle text-success rounded-pill px-3">
                            <i class="bi bi-key me-1"></i>Kode Terkirim
                        </span>
                    </td>
                    <td class="text-muted small">
                        {{ $rental->updated_at->format('d M Y, H:i') }}
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center text-muted py-4">
                        <i class="bi bi-inbox me-2"></i>Tidak ada yang menunggu aktivasi.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection

@section('scripts')
    <script>
        const inputKode = document.querySelector('input[name="kode"]');

        inputKode.addEventListener('input', function () {
            // Hapus semua karakter selain angka
            this.value = this.value.replace(/[^0-9]/g, '');
        });

        inputKode.addEventListener('keypress', function (e) {
            // Blok keypress selain angka
            if (!/[0-9]/.test(e.key)) {
                e.preventDefault();
            }
        });

        // Blok paste yang mengandung huruf
        inputKode.addEventListener('paste', function (e) {
            e.preventDefault();
            const teks  = (e.clipboardData || window.clipboardData).getData('text');
            const angka = teks.replace(/[^0-9]/g, '').slice(0, 5);
            this.value  = angka;
        });
    </script>
@endsection