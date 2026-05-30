@extends('layouts.dashboard')

@section('content')

{{-- Ringkasan Pendapatan --}}
<div class="row g-3 mb-4">
    <div class="col-12 col-sm-4">
        <div class="card border-0 shadow-sm p-3 bg-white rounded-3">
            <small class="text-muted">Total Pendapatan</small>
            <h4 class="fw-bold text-success mb-0">
                IDR {{ number_format($pendapatan, 0, ',', '.') }}
            </h4>
        </div>
    </div>
    <div class="col-12 col-sm-4">
        <div class="card border-0 shadow-sm p-3 bg-white rounded-3">
            <small class="text-muted">Transaksi Selesai</small>
            <h4 class="fw-bold text-primary mb-0">{{ $totalDone }}</h4>
        </div>
    </div>
    <div class="col-12 col-sm-4">
        <div class="card border-0 shadow-sm p-3 bg-white rounded-3">
            <small class="text-muted">Transaksi Ditolak</small>
            <h4 class="fw-bold text-danger mb-0">{{ $totalDitolak }}</h4>
        </div>
    </div>
</div>

<div class="card main-content-card bg-white p-4 mb-4">
    <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-4">
        <h6 class="fw-bold mb-0" style="color: #1e2530;">Riwayat Transaksi</h6>

        {{-- Filter & Search --}}
        <form method="GET" action="{{ route('admin.riwayat') }}"
              class="d-flex gap-2 flex-wrap align-items-center">

            {{-- Search --}}
            <input type="text" name="search"
                   class="form-control form-control-sm"
                   placeholder="Cari nama..."
                   value="{{ request('search') }}"
                   style="width: 160px;">

            {{-- Filter Tanggal --}}
            <select name="filter" class="form-select form-select-sm" style="width: 140px;"
                    onchange="this.form.submit()">
                <option value="semua"     {{ $filter === 'semua'     ? 'selected' : '' }}>Semua</option>
                <option value="hari_ini"  {{ $filter === 'hari_ini'  ? 'selected' : '' }}>Hari Ini</option>
                <option value="minggu_ini"{{ $filter === 'minggu_ini'? 'selected' : '' }}>Minggu Ini</option>
                <option value="bulan_ini" {{ $filter === 'bulan_ini' ? 'selected' : '' }}>Bulan Ini</option>
            </select>

            <button type="submit" class="btn btn-sm btn-primary px-3">Cari</button>
            @if(request('search') || $filter !== 'semua')
                <a href="{{ route('admin.riwayat') }}" class="btn btn-sm btn-outline-secondary">Reset</a>
            @endif
        </form>
    </div>

    <div class="table-responsive">
        <table class="table table-borderless align-middle m-0">
            <thead>
                <tr>
                    <th style="width: 60px;">No</th>
                    <th>Nama</th>
                    <th>Konsol</th>
                    <th>Durasi</th>
                    <th>Total</th>
                    <th>Tgl Sewa</th>
                    <th>Tgl Selesai</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse($riwayat as $i => $rental)
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
                        @if($rental->status === 'done')
                            IDR {{ number_format($rental->total_price, 0, ',', '.') }}
                        @else
                            <span class="text-muted">-</span>
                        @endif
                    </td>
                    <td class="text-muted small">
                        {{ $rental->created_at->format('d M Y') }}
                    </td>
                    <td class="text-muted small">
                        {{ $rental->updated_at->format('d M Y, H:i') }}
                    </td>
                    <td>
                        @if($rental->status === 'done')
                            <span class="badge bg-success rounded-pill px-3">Selesai</span>
                        @else
                            <span class="badge bg-danger rounded-pill px-3">Ditolak</span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="text-center text-muted py-4">
                        <i class="bi bi-inbox me-2"></i>Belum ada riwayat.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection