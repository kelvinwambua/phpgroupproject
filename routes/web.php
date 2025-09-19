<?php
use App\Http\Controllers\Auth\TwoFactorController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('welcome');
})->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('dashboard', function () {
        return Inertia::render('dashboard');
    })->name('dashboard');
});

Route::get('/two-factor', [TwoFactorController::class, 'index'])->name('2fa.index');
Route::post('/two-factor', [TwoFactorController::class, 'store'])->name('2fa.verify');

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
