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
    Route::post('/logout', [KioskController::class, 'logout'])->name('kiosk.logout');
    Route::get('/{department}', [KioskController::class, 'selectUser'])->name('kiosk.user');
});

Route::middleware(['auth', 'verified'])->group(function () {
    

    Route::get('/admin/dashboard', [App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('admin.dashboard');

    // Admin CRUD Routes
    Route::prefix('admin')->name('admin.')->group(function () {
        Route::resource('departments', App\Http\Controllers\Admin\DepartmentController::class);
        Route::resource('users', App\Http\Controllers\Admin\UserController::class);
        Route::resource('periods', App\Http\Controllers\Admin\PeriodController::class);
        Route::resource('assignments', App\Http\Controllers\Admin\AssignmentController::class);
        Route::post('assignments/refresh', [App\Http\Controllers\Admin\AssignmentController::class, 'refresh'])->name('assignments.refresh');
        Route::get('results', [App\Http\Controllers\Admin\UserController::class, 'results'])->name('results.index');
        
        // Report Exports (Semua, Divisi, Individu)
        Route::get('results/export/excel', [App\Http\Controllers\Admin\ReportExportController::class, 'exportAllExcel'])->name('results.export.excel');
        Route::get('results/export/pdf', [App\Http\Controllers\Admin\ReportExportController::class, 'exportAllPdf'])->name('results.export.pdf');
        Route::get('departments/{department}/export/excel', [App\Http\Controllers\Admin\ReportExportController::class, 'exportDepartmentExcel'])->name('departments.export.excel');
        Route::get('departments/{department}/export/pdf', [App\Http\Controllers\Admin\ReportExportController::class, 'exportDepartmentPdf'])->name('departments.export.pdf');
        Route::get('results/{user}/export/excel', [App\Http\Controllers\Admin\ReportExportController::class, 'exportUserExcel'])->name('results.user.export.excel');
        Route::get('results/{user}/export/pdf', [App\Http\Controllers\Admin\ReportExportController::class, 'exportUserPdf'])->name('results.user.export.pdf');

        Route::get('results/{user}', [App\Http\Controllers\Admin\UserController::class, 'userResults'])->name('results.show');
    });

    Route::get('/kpi/no-period', function () {
        return view('kpi.no-period');
    })->name('kpi.no-period');
    Route::get('/kpi/form/{user}', [KpiAssessmentController::class, 'form'])->name('kpi.form');
    Route::post('/kpi/store/{user}', [KpiAssessmentController::class, 'store'])->name('kpi.store');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
