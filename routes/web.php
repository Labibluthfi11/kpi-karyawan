<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\KpiAssessmentController;
use App\Http\Controllers\KioskController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Routes Kiosk (Tanpa Auth)
Route::prefix('kiosk')->group(function () {
    Route::get('/', [KioskController::class, 'selectDepartment'])->name('kiosk.department');
    Route::get('/assessment', [KioskController::class, 'assessment'])->name('kiosk.assessment');
    Route::get('/pin/{user}', [KioskController::class, 'pinForm'])->name('kiosk.pin');
    Route::post('/verify/{user}', [KioskController::class, 'verifyPin'])->name('kiosk.verify');
    Route::get('/{department}', [KioskController::class, 'selectUser'])->name('kiosk.user');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::get('/admin/dashboard', function () {
        return view('admin.dashboard');
    })->name('admin.dashboard');

    Route::get('/kpi', [KpiAssessmentController::class, 'index'])->name('kpi.index');
    Route::get('/kpi/form/{user}', [KpiAssessmentController::class, 'form'])->name('kpi.form');
    Route::post('/kpi/store/{user}', [KpiAssessmentController::class, 'store'])->name('kpi.store');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
