<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\RentalController;
// Landing page — publik
Route::get('/', [RentalController::class, 'index']);

Route::get('/home', [RentalController::class, 'index'])
     ->middleware(['auth'])
     ->name('home');

// Sisanya tetap sama
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'admin'])->name('dashboard');

Route::get('/sewa/{unit_id}/pilih-waktu', [RentalController::class, 'pilihWaktu'])
     ->middleware('auth')
     ->name('sewa.pilih-waktu');

Route::middleware('auth')->group(function () {
    Route::get('/sewa/{unit_id}/pilih-waktu', [RentalController::class, 'pilihWaktu'])->name('sewa.pilih-waktu');
    Route::post('/sewa/{unit_id}/pilih-waktu', [RentalController::class, 'simpanWaktu'])->name('sewa.simpan-waktu');
});

Route::get('/sewa/{rental_id}/pembayaran', [RentalController::class, 'pembayaran'])
     ->middleware('auth')
     ->name('sewa.pembayaran');
     
// -- debugging --
Route::get('/cek-status', function () {
    if (Auth::check()) {
        return [
            'status' => 'SUDAH LOGIN',
            'name'   => Auth::user()->name,
            'email'  => Auth::user()->email,
            'role'   => Auth::user()->role,
        ];
    }
    return ['status' => 'BELUM LOGIN'];
});

Route::get('/force-logout', function () {
    Auth::logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    return redirect('/');
});


// Route::middleware('auth')->group(function () {
//     Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
//     Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
//     Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
// });

require __DIR__.'/auth.php';
