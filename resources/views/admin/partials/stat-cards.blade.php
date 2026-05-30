<div class="row g-3 mb-4">
    <div class="col-12 col-sm-6 col-xl-3">
        <div class="card stat-card p-3 bg-white">
            <div class="icon-box bg-light text-secondary mb-2">
                <i class="bi bi-hourglass-split"></i>
            </div>
            <h3 class="fw-bold m-0">{{ $totalKonfirmasi }}</h3>
            <small class="text-muted">Pelanggan Konfirmasi</small>
        </div>
    </div>
    <div class="col-12 col-sm-6 col-xl-3">
        <div class="card stat-card p-3 bg-white">
            <div class="icon-box bg-success-subtle text-success mb-2">
                <i class="bi bi-check-circle-fill"></i>
            </div>
            <h3 class="fw-bold m-0">{{ $totalAktivasi }}</h3>
            <small class="text-muted">Pelanggan Aktivasi</small>
        </div>
    </div>
    <div class="col-12 col-sm-6 col-xl-3">
        <div class="card stat-card p-3 bg-white">
            <div class="icon-box bg-light text-dark mb-2">
                <i class="bi bi-controller"></i>
            </div>
            <h3 class="fw-bold m-0">{{ $totalBermain }}</h3>
            <small class="text-muted">Pelanggan Bermain</small>
        </div>
    </div>
    <div class="col-12 col-sm-6 col-xl-3">
        <div class="card stat-card p-3 bg-white">
            <div class="icon-box bg-light text-secondary mb-2">
                <i class="bi bi-credit-card-2-back"></i>
            </div>
            <h3 class="fw-bold m-0">
                <span class="text-success">{{ $totalSelesai }}</span>
                <span class="text-muted">/</span>
                <span class="text-danger">{{ $totalDitolak }}</span>
            </h3>
            <small class="text-muted">Transaksi</small>
        </div>
    </div>
</div>