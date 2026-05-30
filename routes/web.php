<?php


use App\Http\Controllers\ProfilController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\RentalController;
use App\Http\Controllers\Admin\DashboardController;

// Landing page — publik
Route::get('/', [RentalController::class, 'index']);

Route::get('/home', [RentalController::class, 'index'])
     ->middleware(['auth'])
     ->name('home');

// Sisanya tetap sama
// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'admin'])->name('dashboard');

Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::post('/konfirmasi/{rental_id}/terima', [DashboardController::class, 'terima'])->name('admin.terima');
    Route::post('/konfirmasi/{rental_id}/tolak', [DashboardController::class, 'tolak'])->name('admin.tolak');
    Route::get('/aktivasi', [DashboardController::class, 'aktivasi'])->name('admin.aktivasi');
    Route::post('/aktivasi/input-kode', [DashboardController::class, 'inputKode'])->name('admin.input-kode');
    Route::get('/bermain', [DashboardController::class, 'bermain'])->name('admin.bermain');
    Route::post('/bermain/{rental_id}/selesai', [DashboardController::class, 'selesai'])->name('admin.selesai');
    Route::get('/bermain/cek-alarm', [DashboardController::class, 'cekAlarm'])->name('admin.cek-alarm');
    Route::get('/riwayat', [DashboardController::class, 'riwayat'])->name('admin.riwayat');
});

// Route::get('/sewa/{unit_id}/pilih-waktu', [RentalController::class, 'pilihWaktu'])
//      ->middleware('auth')
//      ->name('sewa.pilih-waktu');

Route::middleware('auth')->group(function () {
    Route::get('/sewa/{unit_id}/pilih-waktu', [RentalController::class, 'pilihWaktu'])->name('sewa.pilih-waktu');
    Route::post('/sewa/{unit_id}/pilih-waktu', [RentalController::class, 'simpanWaktu'])->name('sewa.simpan-waktu');
    Route::get('/sewa/{rental_id}/pembayaran', [RentalController::class, 'pembayaran'])->name('sewa.pembayaran');
    Route::post('/sewa/{rental_id}/upload-bukti', [RentalController::class, 'uploadBukti'])->name('sewa.upload-bukti');
    Route::get('/sewa/berhasil', [RentalController::class, 'berhasil'])->name('sewa.berhasil');
    Route::get('/profil', [ProfilController::class, 'index'])->name('profil.index');
    Route::get('/profil/history', [ProfilController::class, 'history'])->name('profil.history');
});

// Route::get('/profil/history', function () {
//     return 'halaman history (coming soon)';
// })->middleware('auth')->name('profil.history');

// Route::get('/sewa/{rental_id}/pembayaran', [RentalController::class, 'pembayaran'])
//      ->middleware('auth')
//      ->name('sewa.pembayaran');
     
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
