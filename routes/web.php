<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\RegistrationController;
use App\Http\Controllers\Admin\AuthController as AdminAuthController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\UserController as AdminUserController;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/peserta-terpilih', [HomeController::class, 'selectedParticipants'])->name('participants.selected');
Route::post('/register', [RegistrationController::class, 'store'])->name('register.store');
Route::get('/ticket/{reg_code}', [RegistrationController::class, 'showTicket'])->name('ticket.show');
Route::post('/check-ticket', [HomeController::class, 'checkTicket'])->name('ticket.check');

/*
|--------------------------------------------------------------------------
| Admin Authentication Routes
|--------------------------------------------------------------------------
*/
Route::get('/login', fn () => redirect()->route('admin.login'))->name('login');
Route::get('/admin/login', [AdminAuthController::class, 'showLogin'])->name('admin.login');
Route::post('/admin/login', [AdminAuthController::class, 'login'])->name('admin.login.submit');
Route::post('/admin/logout', [AdminAuthController::class, 'logout'])->name('admin.logout');

/*
|--------------------------------------------------------------------------
| Protected Admin Routes
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', function () {
        return redirect()->route('admin.dashboard');
    });

    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
    Route::get('/participants', [AdminDashboardController::class, 'participants'])->name('participants');
    Route::get('/attendance', [AdminDashboardController::class, 'attendance'])->name('attendance');
    Route::post('/participants/{participant}/promote', [AdminDashboardController::class, 'promote'])->name('participants.promote');
    Route::post('/participants/{participant}/cancel', [AdminDashboardController::class, 'cancel'])->name('participants.cancel');
    Route::post('/participants/{participant}/restore', [AdminDashboardController::class, 'restore'])->name('participants.restore');
    Route::delete('/participants/{participant}', [AdminDashboardController::class, 'destroy'])->name('participants.destroy');
    Route::post('/participants/{participant}/check-in', [AdminDashboardController::class, 'toggleCheckIn'])->name('participants.checkin');
    Route::post('/quick-check-in', [AdminDashboardController::class, 'quickCheckIn'])->name('quickCheckIn');
    Route::get('/export', [AdminDashboardController::class, 'export'])->name('export');
    Route::post('/participants/toggle-publish', [AdminDashboardController::class, 'togglePublishSelected'])->name('participants.togglePublish');
    // Grup Pengaturan Acara (Read-Only untuk Panitia, Simpan/Ubah khusus Administrator)
    Route::get('/settings', [AdminDashboardController::class, 'settings'])->name('settings');
    Route::middleware(['admin'])->group(function () {
        Route::post('/settings', [AdminDashboardController::class, 'updateSettings'])->name('settings.update');
        Route::post('/settings/rundown', [AdminDashboardController::class, 'updateRundown'])->name('settings.updateRundown');
    });

    // Pengelolaan Akun
    // Panitia: hanya melihat akun sendiri & hanya dapat mengubah password sendiri
    // Administrator: CRUD penuh seluruh akun pengguna
    Route::get('/users', [AdminUserController::class, 'index'])->name('users.index');
    Route::post('/users/{user}/change-password', [AdminUserController::class, 'changePassword'])->name('users.changePassword');

    Route::middleware(['admin'])->group(function () {
        Route::post('/users', [AdminUserController::class, 'store'])->name('users.store');
        Route::put('/users/{user}', [AdminUserController::class, 'update'])->name('users.update');
        Route::delete('/users/{user}', [AdminUserController::class, 'destroy'])->name('users.destroy');
    });
});
