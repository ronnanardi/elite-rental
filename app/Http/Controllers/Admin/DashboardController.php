<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Rental;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        // Konfirmasi = rental yg waiting_confirmation
        $konfirmasi = Rental::with(['user', 'unit', 'payments'])
                            ->where('status', 'waiting_confirmation')
                            ->latest()
                            ->get();

        // Stat cards
        $totalKonfirmasi = $konfirmasi->count();
        $totalAktivasi   = Rental::where('status', 'approved')->count();
        $totalBermain    = Rental::where('status', 'active')->count();
        $totalSelesai    = Rental::where('status', 'done')->count();
        $totalDitolak    = Rental::where('status', 'rejected')->count();

        return view('admin.dashboard', compact(
            'konfirmasi',
            'totalKonfirmasi',
            'totalAktivasi',
            'totalBermain',
            'totalSelesai',
            'totalDitolak'
        ));
    }

    public function terima($rental_id)
    {
        $rental = Rental::findOrFail($rental_id);

        // Generate kode 5 digit unik
        do {
            $kode = str_pad(rand(0, 99999), 5, '0', STR_PAD_LEFT);
        } while (Rental::where('activation_code', $kode)->exists());

        // Update rental
        $rental->update([
            'status'          => 'approved',
            'activation_code' => $kode,
        ]);

        // Update payment terakhir
        $rental->payments()->latest()->first()->update([
            'status'      => 'approved',
            'reviewed_by' => Auth::id(),
            'reviewed_at' => now(),
        ]);

        return back()->with('success', 'Pembayaran dikonfirmasi, kode telah dikirim ke user.');
    }

    public function tolak($rental_id)
    {
        $rental = Rental::findOrFail($rental_id);

        $rental->update(['status' => 'rejected']);

        $rental->payments()->latest()->first()->update([
            'status'      => 'rejected',
            'reviewed_by' => Auth::id(),
            'reviewed_at' => now(),
        ]);

        return back()->with('success', 'Pembayaran ditolak.');
    }

    public function aktivasi()
    {
        $menunggu = Rental::with(['user', 'unit'])
                        ->where('status', 'approved')
                        ->latest()
                        ->get();

        return view('admin.aktivasi', compact('menunggu'));
    }

    public function inputKode(Request $request)
    {
        $request->validate([
            'kode' => ['required', 'string', 'size:5'],
        ]);

        $rental = Rental::where('activation_code', $request->kode)
                        ->where('status', 'approved')
                        ->first();

        if (!$rental) {
            return back()->withErrors(['kode' => 'Kode tidak ditemukan atau sudah digunakan.']);
        }

        $rental->update([
            'status'       => 'active',
            'activated_at' => now(),
            'ends_at'      => now()->addMinutes($rental->duration_minutes),
        ]);

        return back()->with('success', $rental->user->name . ' berhasil diaktifkan, sesi berjalan.');
    }

    public function bermain()
    {
        $aktif = Rental::with(['user', 'unit'])
                    ->where('status', 'active')
                    ->latest('activated_at')
                    ->get();

        return view('admin.bermain', compact('aktif'));
    }

    public function selesai($rental_id)
    {
        $rental = Rental::findOrFail($rental_id);
        $rental->update(['status' => 'done']);

        return response()->json(['success' => true, 'nama' => $rental->user->name]);
    }

    // Endpoint polling — dicek JS tiap 10 detik
    public function cekAlarm()
    {
        $selesai = Rental::with(['user', 'unit'])
                        ->where('status', 'active')
                        ->where('ends_at', '<=', now())
                        ->get()
                        ->map(function ($r) {
                            return [
                                'id'      => $r->id,
                                'nama'    => $r->user->name,
                                'konsol'  => $r->unit->console_type,
                                'ends_at' => $r->ends_at,
                            ];
                        });

        return response()->json($selesai);
    }

    public function riwayat(Request $request)
    {
        $filter = $request->filter ?? 'semua';

        $query = Rental::with(['user', 'unit'])
                    ->whereIn('status', ['done', 'rejected']);

        // Filter tanggal
        switch ($filter) {
            case 'hari_ini':
                $query->whereDate('updated_at', today());
                break;
            case 'minggu_ini':
                $query->whereBetween('updated_at', [now()->startOfWeek(), now()->endOfWeek()]);
                break;
            case 'bulan_ini':
                $query->whereMonth('updated_at', now()->month)
                    ->whereYear('updated_at', now()->year);
                break;
        }

        // Cari nama user
        if ($request->search) {
            $query->whereHas('user', function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%');
            });
        }

        $riwayat = $query->latest()->get();

        // Pendapatan hanya dari yang done
        $pendapatan = $riwayat->where('status', 'done')->sum('total_price');
        $totalDone      = $riwayat->where('status', 'done')->count();
        $totalDitolak   = $riwayat->where('status', 'rejected')->count();

        return view('admin.riwayat', compact(
            'riwayat', 'pendapatan', 'totalDone', 'totalDitolak', 'filter'
        ));
    }
}
