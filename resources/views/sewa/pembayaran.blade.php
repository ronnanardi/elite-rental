@extends('layouts.landing')

@section('content')
<div class="container my-5" style="max-width: 860px;">

    <h4 class="fw-bold mb-3">Rental Anda</h4>

    {{-- Hero Unit --}}
    <div class="row bg-primary text-white p-4 p-md-5 mb-4 align-items-center mx-0 rounded-3">
        <div class="col-md-8 text-center text-md-start">
            <h1 class="display-4 fw-bold">{{ $rental->unit->console_type }}</h1>
            <p class="lead text-white-50 fs-6">{{ $rental->unit->description }}</p>
            <div class="mt-3">
                <span class="badge bg-white text-primary rounded-pill px-3 py-2 me-2">
                    <i class="bi bi-clock me-1"></i>
                    @php
                        $jam   = intdiv($rental->duration_minutes, 60);
                        $menit = $rental->duration_minutes % 60;
                    @endphp
                    {{ $jam > 0 ? $jam . ' Jam' : '' }} {{ $menit > 0 ? $menit . ' Menit' : '' }}
                </span>
                <span class="badge bg-white text-primary rounded-pill px-3 py-2">
                    <i class="bi bi-cash me-1"></i>
                    IDR {{ number_format($rental->total_price, 0, ',', '.') }}
                </span>
            </div>
        </div>
        <div class="col-md-4 text-center mt-4 mt-md-0">
            <img src="{{ $rental->unit->image }}" alt="{{ $rental->unit->console_type }}"
                 style="height: 150px; object-fit: contain;">
        </div>
    </div>

    {{-- Form Upload Bukti + QR --}}
    <div class="card border-0 shadow-sm p-4 rounded-3">
        <div class="row d-flex flex-column-reverse flex-md-row">

            {{-- Kiri: Detail & Upload --}}
            <div class="col-md-8">
                <h5 class="fw-bold mb-3">Upload Bukti Pembayaran</h5>

                {{-- Ringkasan --}}
                <div class="bg-light rounded-3 p-3 mb-4">
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted small">Konsol</span>
                        <span class="fw-semibold small">{{ $rental->unit->console_type }}</span>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted small">Durasi</span>
                        <span class="fw-semibold small">
                            {{ $jam > 0 ? $jam . ' Jam ' : '' }}{{ $menit > 0 ? $menit . ' Menit' : '' }}
                        </span>
                    </div>
                    <hr class="my-2">
                    <div class="d-flex justify-content-between">
                        <span class="text-muted small">Total Bayar</span>
                        <span class="fw-bold text-primary">
                            IDR {{ number_format($rental->total_price, 0, ',', '.') }}
                        </span>
                    </div>
                </div>

                {{-- Info Bank --}}
                <div class="bg-light rounded-3 p-3 mb-4">
                    <p class="text-muted small mb-1">Transfer ke rekening:</p>
                    <p class="fw-bold mb-0">{{ $settings['bank_name'] ?? '-' }}</p>
                    <p class="fw-bold fs-5 mb-0 text-primary">{{ $settings['account_number'] ?? '-' }}</p>
                    <p class="text-muted small mb-0">a/n {{ $settings['account_name'] ?? '-' }}</p>
                </div>

                {{-- Error --}}
                @if($errors->any())
                    <div class="alert alert-danger rounded-3 small">{{ $errors->first() }}</div>
                @endif

                {{-- Form Upload --}}
                <form method="POST"
                      action="{{ route('sewa.upload-bukti', $rental->id) }}"
                      enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label small fw-medium">Foto Bukti Transfer</label>
                        <input type="file"
                               name="proof_image"
                               class="form-control"
                               accept="image/*"
                               required>
                        <div class="form-text">Format: JPG, PNG. Maks 2MB.</div>
                    </div>
                    <button type="submit" class="btn btn-success w-100 py-2 fw-bold">
                        Upload Bukti
                    </button>
                </form>
            </div>

            {{-- Kanan: QR --}}
            <div class="col-md-4 text-center d-flex flex-column align-items-center justify-content-center mb-4 mb-md-0">
                @if(!empty($settings['qris_image']))
                    <img src="{{ asset($settings['qris_image']) }}"
                         alt="QRIS"
                         style="width: 180px; height: 180px; object-fit: contain;"
                         class="border p-2 mb-2">
                @else
                    <div class="border p-3 bg-white mb-2 d-flex align-items-center justify-content-center"
                         style="width: 180px; height: 180px;">
                        <span class="text-muted small">[ QR CODE ]</span>
                    </div>
                @endif
                <div class="fw-bold text-muted lh-1" style="font-size: 1.5rem; letter-spacing: 2px;">
                    QRIS
                </div>
            </div>

        </div>
    </div>

</div>
@endsection