<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Unit;
use App\Models\Rental;
use Illuminate\Http\Request;
use App\Models\Setting;
use App\Models\Payment;

class RentalController extends Controller
{
    // Landing page — kirim data units ke view
    public function index()
    {
        $units = Unit::all();
        return view('landing-page', compact('units'));
    }

    // Halaman pilih waktu
    public function pilihWaktu($unit_id)
    {
        $unit = Unit::findOrFail($unit_id);

        // Cek ketersediaan
        $sedangAktif = Rental::where('unit_id', $unit->id)
                            ->where('status', 'active')
                            ->count();
        $tersedia = $unit->total - $sedangAktif;

        if (!$unit->is_open || $tersedia <= 0) {
            return redirect('/')->with('error', $unit->console_type . ' sedang tidak tersedia.');
        }

        $hargaJam   = $unit->priceSlots()->where('type', 'hour')->orderBy('value')->get();
        $hargaMenit = $unit->priceSlots()->where('type', 'minute')->orderBy('value')->get();

        return view('sewa.pilih-waktu', compact('unit', 'hargaJam', 'hargaMenit'));
    }

    public function simpanWaktu(Request $request, $unit_id)
    {
        $unit = Unit::findOrFail($unit_id);

        $request->validate([
            'jam'   => ['required', 'integer', 'min:0', 'max:5'],
            'menit' => ['required', 'integer', 'in:0,10,20,30,40,50'],
        ]);

        // Validasi minimal 10 menit
        $totalMenit = ($request->jam * 60) + $request->menit;
        if ($totalMenit < 10) {
            return back()->withErrors(['durasi' => 'Minimal pemesanan 10 menit.']);
        }

        // Hitung harga
        $hargaJam = 0;
        if ($request->jam > 0) {
            $slotJam  = $unit->priceSlots()->where('type', 'hour')->where('value', $request->jam)->first();
            $hargaJam = $slotJam ? $slotJam->price : 0;
        }

        $hargaMenit = 0;
        if ($request->menit > 0) {
            $slotMenit  = $unit->priceSlots()->where('type', 'minute')->where('value', $request->menit)->first();
            $hargaMenit = $slotMenit ? $slotMenit->price : 0;
        }

        $totalHarga = $hargaJam + $hargaMenit;

        // Simpan rental ke DB
        $rental = Rental::create([
            'user_id'          => Auth::id(),
            'unit_id'          => $unit->id,
            'duration_minutes' => $totalMenit,
            'total_price'      => $totalHarga,
            'status'           => 'pending_payment',
        ]);

        return redirect()->route('sewa.pembayaran', $rental->id);
    }

    public function pembayaran($rental_id)
    {
        $rental = Rental::with('unit')->findOrFail($rental_id);

        // Pastikan rental milik user yang login
        if ($rental->user_id !== Auth::id()) {
            abort(403);
        }

        // Ambil setting QR & bank
        $settings = Setting::whereIn('key', [
            'qris_image',
            'bank_name',
            'account_number',
            'account_name',
        ])->pluck('value', 'key');

        return view('sewa.pembayaran', compact('rental', 'settings'));
    }

    public function uploadBukti(Request $request, $rental_id)
    {
        $rental = Rental::findOrFail($rental_id);

        if ($rental->user_id !== Auth::id()) {
            abort(403);
        }

        $request->validate([
            'proof_image' => ['required', 'image', 'mimes:jpg,jpeg,png', 'max:2048'],
        ]);

        // Simpan gambar
        $path = $request->file('proof_image')->store('payments', 'public');

        // Simpan ke tabel payments
        Payment::create([
            'rental_id'   => $rental->id,
            'proof_image' => $path,
            'status'      => 'pending',
        ]);

        // Update status rental
        $rental->update(['status' => 'waiting_confirmation']);

        return redirect()->route('sewa.berhasil')->with('berhasil', [
            'konsol'  => $rental->unit->console_type,
            'durasi'  => $rental->duration_minutes,
            'total'   => $rental->total_price,
        ]);
    }

    public function berhasil()
    {
        // Jika tidak ada data session, lempar ke home
        if (!session('berhasil')) {
            return redirect('/');
        }

        return view('sewa.berhasil');
    }
}
