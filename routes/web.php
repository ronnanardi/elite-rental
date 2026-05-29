<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

// Landing page — publik
Route::get('/', function () {
    return view('landing-page');
});

// Landing page user setelah login (bisa sama view-nya)
Route::get('/home', function () {
    return view('landing-page');
})->middleware(['auth'])->name('home');

// Dashboard admin
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'admin'])->name('dashboard'); // middleware role admin

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
