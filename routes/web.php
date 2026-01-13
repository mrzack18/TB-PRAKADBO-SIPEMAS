<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\NewsController;
use App\Http\Controllers\Admin\ComplaintController;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware('auth')->group(function () {
    // Role-based dashboard redirect
    Route::get('/dashboard', function () {
        $user = auth()->user();

        return match ($user->role) {
            'admin' => redirect()->route('admin.dashboard'),
            'staf_desa' => redirect()->route('staff.dashboard'),
            'perwakilan_masyarakat' => redirect()->route('citizen.dashboard'),
            default => abort(403, 'Invalid role assigned to user')
        };
    })->name('dashboard');

    // Admin routes
    Route::middleware('admin')->group(function () {
        Route::prefix('admin')->name('admin.')->group(function () {
            Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

            // User management routes
            Route::resource('users', UserController::class);

            // News management routes
            Route::resource('news', NewsController::class);

            // Complaint management routes
            Route::resource('complaints', ComplaintController::class);
        });
    });

    // Staff Desa routes
    Route::middleware('staff')->group(function () {
        Route::prefix('staff')->name('staff.')->group(function () {
            Route::get('/dashboard', [\App\Http\Controllers\Staff\StaffDashboardController::class, 'index'])->name('dashboard');

            // Complaint management routes for staff
            Route::resource('complaints', \App\Http\Controllers\Staff\StaffComplaintController::class);

            // News management routes for staff
            Route::resource('news', \App\Http\Controllers\Staff\StaffNewsController::class);
        });
    });

    // Comment routes - accessible to all authenticated users
    Route::middleware('auth')->group(function () {
        Route::post('/comments', [\App\Http\Controllers\CommentController::class, 'store'])->name('comments.store');
        Route::put('/comments/{comment}', [\App\Http\Controllers\CommentController::class, 'update'])->name('comments.update');
        Route::delete('/comments/{comment}', [\App\Http\Controllers\CommentController::class, 'destroy'])->name('comments.destroy');
    });

    // Citizen/Warga routes
    Route::middleware('citizen')->group(function () {
        Route::prefix('citizen')->name('citizen.')->group(function () {
            Route::get('/dashboard', [\App\Http\Controllers\Citizen\CitizenDashboardController::class, 'index'])->name('dashboard');

            // Complaint management routes for citizens
            Route::resource('complaints', \App\Http\Controllers\Citizen\CitizenComplaintController::class);

            // News viewing routes for citizens
            Route::resource('news', \App\Http\Controllers\Citizen\CitizenNewsController::class)->only(['index', 'show']);
        });
    });
});
