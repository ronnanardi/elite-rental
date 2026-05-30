@extends('layouts.dashboard')
@section('content')

{{-- Flash message --}}
@if(session('success'))
    <div class="alert alert-success rounded-3 small py-2 mb-3">{{ session('success') }}</div>
@endif


{{-- Tabel Konfirmasi --}}
<div class="card main-content-card bg-white p-4 mb-4">
    <h6 class="fw-bold mb-4" style="color: #1e2530;">Konfirmasi Pembayaran</h6>

    <div class="table-responsive">
        <table class="table table-borderless align-middle m-0">
            <thead>
                <tr>
                    <th style="width: 60px;">No</th>
                    <th>Nama</th>
                    <th>Konsol</th>
                    <th>Durasi</th>
                    <th>Total</th>
                    <th>Tanggal</th>
                    <th>Bukti</th>
                    <th style="min-width: 160px;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($konfirmasi as $i => $rental)
                @php
                    $jam     = intdiv($rental->duration_minutes, 60);
                    $menit   = $rental->duration_minutes % 60;
                    $payment = $rental->payments->last();
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
                    <td class="text-muted small">
                        {{ $rental->created_at->format('d M Y') }}
                    </td>
                    <td>
                        @if($payment && $payment->proof_image)
                            <button class="btn btn-sm btn-custom-blue py-1 px-2 small"
                                    data-bs-toggle="modal"
                                    data-bs-target="#modalGambar"
                                    data-img="{{ asset('storage/' . $payment->proof_image) }}"
                                    data-nama="{{ $rental->user->name }}">
                                Lihat Gambar
                            </button>
                        @else
                            <span class="text-muted small">-</span>
                        @endif
                    </td>
                    <td>
                        <div class="d-flex gap-1">
                            <form method="POST" action="{{ route('admin.terima', $rental->id) }}">
                                @csrf
                                <button type="submit"
                                        class="btn btn-sm btn-custom-green py-1 px-2 small"
                                        onclick="return confirm('Konfirmasi pembayaran ini?')">
                                    Terima
                                </button>
                            </form>
                            <form method="POST" action="{{ route('admin.tolak', $rental->id) }}">
                                @csrf
                                <button type="submit"
                                        class="btn btn-sm btn-custom-red py-1 px-2 small"
                                        onclick="return confirm('Tolak pembayaran ini?')">
                                    Tolak
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="text-center text-muted py-4">
                        <i class="bi bi-inbox me-2"></i>Tidak ada pembayaran yang menunggu konfirmasi.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

{{-- Modal Lihat Gambar --}}
<div class="modal fade" id="modalGambar" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 rounded-4">
            <div class="modal-header border-0">
                <h6 class="modal-title fw-bold" id="modalNama">Bukti Pembayaran</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body text-center p-3">
                <img id="modalImg" src="" alt="Bukti"
                     class="img-fluid rounded-3" style="max-height: 500px;">
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
    document.getElementById('modalGambar').addEventListener('show.bs.modal', function (e) {
        const btn  = e.relatedTarget;
        document.getElementById('modalImg').src            = btn.getAttribute('data-img');
        document.getElementById('modalNama').textContent   = 'Bukti - ' + btn.getAttribute('data-nama');
    });
</script>
@endsection
