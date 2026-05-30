@extends('layouts.dashboard')

@section('content')

<div class="card main-content-card bg-white p-4 mb-4">
    <h6 class="fw-bold mb-4" style="color: #1e2530;">Sedang Bermain</h6>

    <div class="table-responsive">
        <table class="table table-borderless align-middle m-0" id="tabelBermain">
            <thead>
                <tr>
                    <th style="width: 60px;">No</th>
                    <th>Nama</th>
                    <th>Konsol</th>
                    <th>Durasi</th>
                    <th>Mulai</th>
                    <th>Sisa Waktu</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($aktif as $i => $rental)
                @php
                    $jam   = intdiv($rental->duration_minutes, 60);
                    $menit = $rental->duration_minutes % 60;
                @endphp
                <tr id="row-{{ $rental->id }}" data-ends="{{ $rental->ends_at->timestamp }}">
                    <td class="text-muted">{{ str_pad($i + 1, 2, '0', STR_PAD_LEFT) }}</td>
                    <td class="fw-semibold">{{ $rental->user->name }}</td>
                    <td>{{ $rental->unit->console_type }}</td>
                    <td class="small">
                        {{ $jam > 0 ? $jam . 'j ' : '' }}{{ $menit > 0 ? $menit . 'm' : '' }}
                    </td>
                    <td class="text-muted small">
                        {{ $rental->activated_at->format('H:i') }}
                    </td>
                    <td>
                        <span class="countdown fw-bold font-monospace" id="cd-{{ $rental->id }}">
                            --:--:--
                        </span>
                    </td>
                    <td>
                        <button class="btn btn-sm btn-custom-green py-1 px-3 small btn-selesai"
                                data-id="{{ $rental->id }}"
                                data-nama="{{ $rental->user->name }}">
                            Selesai
                        </button>
                    </td>
                </tr>
                @empty
                <tr id="emptyRow">
                    <td colspan="7" class="text-center text-muted py-4">
                        <i class="bi bi-controller me-2"></i>Tidak ada yang sedang bermain.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

{{-- Audio alarm --}}
<audio id="alarmSound" loop>
    <source src="https://www.soundjay.com/misc/sounds/bell-ringing-05.mp3" type="audio/mpeg">
</audio>

@endsection

@section('scripts')
<script>
// =============================================
// UNTUK TESTING: set ends_at ke 10 detik dari sekarang
// Uncomment baris ini, refresh, tunggu 10 detik
// const TEST_MODE = true;
// =============================================

const alarmSound   = document.getElementById('alarmSound');
const activeAlarms = new Set(); // tracking row yg sudah alarm
let browserNotif   = {};        // simpan notif per rental id

// Minta izin notifikasi browser saat halaman dibuka
if ('Notification' in window && Notification.permission === 'default') {
    Notification.requestPermission();
}

// ── COUNTDOWN PER ROW ──────────────────────────────
function updateCountdown() {
    const rows = document.querySelectorAll('tr[data-ends]');

    rows.forEach(row => {
        const id      = row.id.replace('row-', '');
        const endsAt  = new Date(row.dataset.ends * 1000);
        const sekarang = new Date();
        const sisa    = endsAt - sekarang;
        const cdEl    = document.getElementById('cd-' + id);

        if (!cdEl) return;

        if (sisa <= 0) {
            // Waktu habis
            if (!activeAlarms.has(id)) {
                activeAlarms.add(id);
                triggerAlarm(id, row);
            }

            // Kedip 00:00:00
            cdEl.textContent = '00:00:00';
            cdEl.classList.add('text-danger');
            cdEl.style.animation = 'kedip 0.5s step-start infinite';

        } else {
            const h = String(Math.floor(sisa / 3600000)).padStart(2, '0');
            const m = String(Math.floor((sisa % 3600000) / 60000)).padStart(2, '0');
            const s = String(Math.floor((sisa % 60000) / 1000)).padStart(2, '0');

            cdEl.textContent = `${h}:${m}:${s}`;

            // Warna kuning jika sisa < 5 menit
            if (sisa < 300000) {
                cdEl.classList.remove('text-success');
                cdEl.classList.add('text-warning');
            } else {
                cdEl.classList.add('text-success');
            }
        }
    });
}

// ── TRIGGER ALARM ───────────────────────────────────
function triggerAlarm(id, row) {
    // Bunyi alarm
    alarmSound.play().catch(() => {});

    // Row jadi merah
    row.classList.add('table-danger');

    // Notif browser
    if ('Notification' in window && Notification.permission === 'granted') {
        const nama   = row.querySelector('td:nth-child(2)').textContent.trim();
        const konsol = row.querySelector('td:nth-child(3)').textContent.trim();

        browserNotif[id] = new Notification('⏰ Waktu Habis!', {
            body : nama + ' - ' + konsol + ' sudah selesai.',
            icon : '/favicon.ico',
            tag  : 'alarm-' + id,
        });

        browserNotif[id].onclick = function () {
            window.focus();
            this.close();
        };
    }
}

// ── TOMBOL SELESAI ──────────────────────────────────
document.querySelectorAll('.btn-selesai').forEach(btn => {
    btn.addEventListener('click', function () {
        const id   = this.dataset.id;
        const nama = this.dataset.nama;
        const row  = document.getElementById('row-' + id);
        const cdEl = document.getElementById('cd-' + id);

        // Kirim ke server
        fetch(`/admin/bermain/${id}/selesai`, {
            method  : 'POST',
            headers : {
                'X-CSRF-TOKEN' : document.querySelector('meta[name="csrf-token"]').content,
                'Content-Type' : 'application/json',
            },
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                // Tutup notif browser
                if (browserNotif[id]) {
                    browserNotif[id].close();
                    delete browserNotif[id];
                }

                // Stop alarm jika tidak ada alarm lain
                activeAlarms.delete(id);
                if (activeAlarms.size === 0) {
                    alarmSound.pause();
                    alarmSound.currentTime = 0;
                }

                // Stop kedip, set 00:00:00
                cdEl.style.animation = 'none';
                cdEl.textContent     = '00:00:00';

                // Jeda 5 detik lalu hilangkan row
                row.style.transition = 'opacity 1s';
                setTimeout(() => {
                    row.style.opacity = '0';
                    setTimeout(() => {
                        row.remove();
                        // Cek apakah tabel kosong
                        const tbody = document.querySelector('#tabelBermain tbody');
                        if (tbody.querySelectorAll('tr[data-ends]').length === 0) {
                            tbody.innerHTML = `
                                <tr><td colspan="7" class="text-center text-muted py-4">
                                    <i class="bi bi-controller me-2"></i>Tidak ada yang sedang bermain.
                                </td></tr>`;
                        }
                    }, 1000);
                }, 5000); // jeda 5 detik
            }
        });
    });
});

// ── CARA CEK TANPA MENUNGGU ─────────────────────────
// Buka console browser (F12), ketik:
// forceAlarm('ID_RENTAL')   → paksa alarm row tertentu
// forceAllDone()             → paksa semua selesai

window.forceAlarm = function(id) {
    const row = document.getElementById('row-' + id);
    if (row) {
        activeAlarms.add(String(id));
        triggerAlarm(String(id), row);
        console.log('Alarm dipaksa untuk rental ID:', id);
    } else {
        console.log('Row tidak ditemukan, ID:', id);
    }
};

window.forceAllDone = function() {
    document.querySelectorAll('tr[data-ends]').forEach(row => {
        const id = row.id.replace('row-', '');
        row.dataset.ends = new Date(Date.now() - 1000).toISOString().replace('T', ' ').slice(0, 19);
        console.log('Set selesai:', id);
    });
};

// ── JALANKAN ────────────────────────────────────────
setInterval(updateCountdown, 1000); // update tiap detik
updateCountdown(); // langsung jalan saat load

</script>

{{-- CSS kedip --}}
<style>
@keyframes kedip {
    0%, 100% { opacity: 1; }
    50%       { opacity: 0; }
}
</style>
@endsection