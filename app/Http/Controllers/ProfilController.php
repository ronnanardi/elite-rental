<?php

namespace App\Http\Controllers;

use App\Models\Rental;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class ProfilController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Statistik singkat
        $totalSewa    = Rental::where('user_id', $user->id)->count();
        $totalBermain = Rental::where('user_id', $user->id)->where('status', 'done')->count();
        $totalBelum   = Rental::where('user_id', $user->id)
                              ->whereNotIn('status', ['done', 'rejected'])
                              ->count();
        $totalDitolak = Rental::where('user_id', $user->id)
                      ->where('status', 'rejected')
                      ->count();

        return view('profil.index', compact('user', 'totalSewa', 'totalBermain', 'totalBelum', 'totalDitolak'));
    }

    public function history()
    {
        $user    = Auth::user();
        $rentals = Rental::with(['unit', 'payments'])
                         ->where('user_id', $user->id)
                         ->latest()
                         ->get();

        return view('profil.history', compact('user', 'rentals'));
    }
}
