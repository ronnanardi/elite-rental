@extends('layouts.landing')

@section('content')
<div class="container my-5" style="max-width: 860px;">

    <h4 class="fw-bold mb-3">Rental Anda</h4>

    {{-- Error durasi --}}
    @if($errors->any())
        <div class="alert alert-danger rounded-3 small">{{ $errors->first() }}</div>
    @endif

    {{-- Hero Unit --}}
    <div class="row bg-primary text-white p-4 p-md-5 mb-4 align-items-center mx-0 rounded-3">
        <div class="col-md-8 text-center text-md-start">
            <h1 class="display-4 fw-bold">{{ $unit->console_type }}</h1>
            <p class="lead text-white-50 fs-6">{{ $unit->description }}</p>
        </div>
        <div class="col-md-4 text-center mt-4 mt-md-0">
            <img src="{{ $unit->image }}" alt="{{ $unit->console_type }}"
                 style="height: 150px; object-fit: contain;">
        </div>
    </div>

    {{-- Form Pilih Waktu --}}
    <div class="card border-0 shadow-sm p-4 rounded-3">
        <form method="POST" action="{{ route('sewa.simpan-waktu', $unit->id) }}" id="formSewa">
            @csrf
            {{-- hidden input untuk jam & menit --}}
            <input type="hidden" name="jam" id="inputJam" value="0">
            <input type="hidden" name="menit" id="inputMenit" value="0">

            <div class="row d-flex flex-column-reverse flex-md-row">

                {{-- Kiri: Pilih Waktu --}}
                <div class="col-md-8">
                    <h5 class="fw-bold mb-3">Pilih Waktu</h5>

                    {{-- Jam --}}
                    <p class="mb-2 text-muted small">Jam :</p>
                    <div class="d-flex flex-wrap gap-2 mb-3">
                        <button type="button"
                                class="btn btn-outline-primary rounded-pill px-4 btn-sm btn-jam active"
                                data-jam="0" data-harga="0">
                            0 Jam
                        </button>
                        @foreach($hargaJam as $slot)
                        <button type="button"
                                class="btn btn-outline-primary rounded-pill px-4 btn-sm btn-jam"
                                data-jam="{{ $slot->value }}"
                                data-harga="{{ $slot->price }}">
                            {{ $slot->value }} Jam
                        </button>
                        @endforeach
                    </div>

                    {{-- Menit --}}
                    <p class="mb-2 text-muted small">Menit :</p>
                    <div class="d-flex flex-wrap gap-2 mb-4">
                        <button type="button"
                                class="btn btn-outline-primary rounded-pill px-3 btn-sm btn-menit active"
                                data-menit="0" data-harga="0">
                            0 Menit
                        </button>
                        @foreach($hargaMenit as $slot)
                        <button type="button"
                                class="btn btn-outline-primary rounded-pill px-3 btn-sm btn-menit"
                                data-menit="{{ $slot->value }}"
                                data-harga="{{ $slot->price }}">
                            {{ $slot->value }} Menit
                        </button>
                        @endforeach
                    </div>

                    {{-- Total & Submit --}}
                    <div class="row align-items-center mt-4 pt-2">
                        <div class="col-6 mb-3 mb-md-0">
                            <span class="text-muted small">Total</span>
                        </div>
                        <div class="col-6 text-end mb-3 mb-md-0">
                            <span class="fw-bold fs-5" id="totalHarga">IDR 0</span>
                        </div>
                        <div class="col-12 mt-2">
                            <button type="submit" id="btnSubmit"
                                    class="btn btn-success w-100 py-2 fw-bold" disabled>
                                Lanjut Pembayaran
                            </button>
                            <p class="text-danger small mt-1 text-center" id="pesanMinimal" style="display:none;">
                                Minimal pemesanan 10 menit.
                            </p>
                        </div>
                    </div>
                </div>

                {{-- Kanan: Info --}}
                <div class="col-md-4 text-center d-flex flex-column align-items-center justify-content-center mb-4 mb-md-0">
                    <img src="{{ $unit->image }}" alt="{{ $unit->console_type }}"
                         style="height: 140px; object-fit: contain;" class="mb-3">
                    <div class="badge bg-success rounded-pill px-3 py-2 mb-2">
                        @php
                            $aktif    = \App\Models\Rental::where('unit_id', $unit->id)->where('status','active')->count();
                            $tersedia = $unit->total - $aktif;
                        @endphp
                        {{ $tersedia }} unit tersedia
                    </div>
                    <small class="text-muted">{{ $unit->console_type }}</small>
                </div>

            </div>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script>
    let hargaJam   = 0;
    let hargaMenit = 0;
    let nilaiJam   = 0;
    let nilaiMenit = 0;

    function formatRupiah(angka) {
        return 'IDR ' + angka.toLocaleString('id-ID');
    }

    function updateTotal() {
        const total       = hargaJam + hargaMenit;
        const totalMenit  = (nilaiJam * 60) + nilaiMenit;
        const minimal     = totalMenit >= 10;

        document.getElementById('totalHarga').textContent = formatRupiah(total);
        document.getElementById('inputJam').value         = nilaiJam;
        document.getElementById('inputMenit').value       = nilaiMenit;
        document.getElementById('btnSubmit').disabled     = !minimal;
        document.getElementById('pesanMinimal').style.display = minimal ? 'none' : 'block';
    }

    // Tombol Jam
    document.querySelectorAll('.btn-jam').forEach(btn => {
        btn.addEventListener('click', function () {
            document.querySelectorAll('.btn-jam').forEach(b => b.classList.remove('active'));
            this.classList.add('active');
            hargaJam  = parseInt(this.dataset.harga);
            nilaiJam  = parseInt(this.dataset.jam);
            updateTotal();
        });
    });

    // Tombol Menit
    document.querySelectorAll('.btn-menit').forEach(btn => {
        btn.addEventListener('click', function () {
            document.querySelectorAll('.btn-menit').forEach(b => b.classList.remove('active'));
            this.classList.add('active');
            hargaMenit = parseInt(this.dataset.harga);
            nilaiMenit = parseInt(this.dataset.menit);
            updateTotal();
        });
    });
</script>
@endsection