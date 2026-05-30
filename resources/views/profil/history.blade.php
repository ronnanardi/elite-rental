@extends('layouts.landing')

@section('content')
<div class="container my-5" style="max-width: 960px;">

    {{-- Header --}}
    <div class="d-flex align-items-center gap-3 mb-4">
        <a href="{{ route('profil.index') }}" class="btn btn-light btn-sm rounded-pill px-3">
            <i class="bi bi-arrow-left me-1"></i>Profil
        </a>
        <h4 class="fw-bold mb-0">History Rental</h4>
    </div>

    {{-- Flash success --}}
    @if(session('success'))
        <div class="alert alert-success rounded-3 small">{{ session('success') }}</div>
    @endif

    <div class="card border-0 shadow-sm rounded-4 p-4">

        @if($rentals->isEmpty())
            <div class="text-center py-5">
                <i class="bi bi-inbox text-muted" style="font-size: 3rem;"></i>
                <p class="text-muted mt-3">Belum ada riwayat sewa.</p>
                <a href="/" class="btn btn-primary rounded-pill px-4">Sewa Sekarang</a>
            </div>
        @else
            <div class="table-responsive">
                <table class="table table-borderless align-middle">
                    <thead class="table-light">
                        <tr>
                            <th class="rounded-start">No</th>
                            <th>Konsol</th>
                            <th>Durasi</th>
                            <th>Total</th>
                            <th>Tanggal</th>
                            <th>Status</th>
                            <th class="rounded-end">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($rentals as $i => $rental)
                        @php
                            $jam   = intdiv($rental->duration_minutes, 60);
                            $menit = $rental->duration_minutes % 60;
                        @endphp
                        <tr>
                            <td class="text-muted small">{{ str_pad($i + 1, 2, '0', STR_PAD_LEFT) }}</td>
                            <td class="fw-semibold">{{ $rental->unit->console_type }}</td>
                            <td class="small">
                                {{ $jam > 0 ? $jam . 'j ' : '' }}{{ $menit > 0 ? $menit . 'm' : '' }}
                            </td>
                            <td class="small fw-semibold">
                                IDR {{ number_format($rental->total_price, 0, ',', '.') }}
                            </td>
                            <td class="text-muted small">
                                {{ $rental->created_at->format('d M Y') }}
                            </td>
                            <td>
                                @php
                                    $badge = [
                                        'pending_payment'      => ['bg-secondary', 'Menunggu Bayar'],
                                        'waiting_confirmation' => ['bg-warning text-dark', 'Menunggu Konfirmasi'],
                                        'approved'             => ['bg-info text-dark', 'Disetujui'],
                                        'active'               => ['bg-primary', 'Sedang Bermain'],
                                        'done'                 => ['bg-success', 'Selesai'],
                                        'rejected'             => ['bg-danger', 'Ditolak'],
                                    ][$rental->status] ?? ['bg-secondary', $rental->status];
                                @endphp
                                <span class="badge {{ $badge[0] }} rounded-pill px-3">
                                    {{ $badge[1] }}
                                </span>
                            </td>
                            <td>
                                {{-- Aksi berdasarkan status --}}
                                @if($rental->status === 'approved')
                                    <span class="badge bg-info text-dark rounded-pill px-3">
                                        <i class="bi bi-key me-1"></i>{{ $rental->activation_code }}
                                    </span>

                                @elseif($rental->status === 'rejected')
                                    <a href="{{ route('sewa.pembayaran', $rental->id) }}"
                                       class="btn btn-sm btn-danger rounded-pill px-3">
                                        Upload Ulang
                                    </a>

                                @elseif($rental->status === 'pending_payment')
                                    <a href="{{ route('sewa.pembayaran', $rental->id) }}"
                                       class="btn btn-sm btn-warning rounded-pill px-3">
                                        Bayar
                                    </a>

                                @elseif($rental->status === 'waiting_confirmation')
                                    <span class="text-muted small">Menunggu admin...</span>

                                @elseif($rental->status === 'active')
                                    <span class="text-muted small">Sedang berjalan</span>

                                @elseif($rental->status === 'done')
                                    <span class="text-muted small">
                                        <i class="bi bi-check-circle-fill text-success me-1"></i>Selesai
                                    </span>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif

    </div>
</div>
@endsection