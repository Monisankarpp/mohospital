<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;


Route::get('/', function () {
    return view('welcome');
});

Route::middleware('guest')->group(function () {
    Route::get('register', [RegisterController::class, 'show'])->name('register.form');
    Route::post('register', [RegisterController::class, 'register'])->name('register.submit');
});

Route::middleware('auth')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login'])->name('login.submit');
});

Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
// ->middleware('auth')
// ->name('logout');


Route::controller(ForgotPasswordController::class)
    ->middleware('guest')
    ->group(function () {
        Route::get('/forgot-password', 'showLinkRequestForm')->name('password.request');
        Route::post('/forgot-password', 'sendResetLinkEmail')->name('password.email');
    });

Route::controller(ResetPasswordController::class)
    ->middleware('guest')
    ->group(function () {
        Route::get('/reset-password/{token}', 'showResetForm')->name('password.reset');
        Route::post('/reset-password', 'reset')->name('password.update');
    });





Route::middleware(['role:patient'])->get('/dashboard/patient', function () {
    return view('dashboards.patient');
})->name('patient.dashboard');



// Doctor Dashboard
Route::middleware(['role:doctor'])->get('/dashboard/doctor', function () {
    return view('dashboards.doctor');
})->name('doctor.dashboard');

// Medical Store Owner Dashboard
Route::middleware(['role:medical_store_owner'])->get('/dashboard/medical-store', function () {
    return view('dashboards.medical-store');
})->name('medical-store.dashboard');

// Hospital Owner Dashboard
Route::middleware(['role:hospital_owner'])->get('/dashboard/hospital', function () {
    return view('dashboards.hospital');
})->name('hospital.dashboard');

// Super Admin Dashboard
Route::middleware(['role:super_admin'])->get('/dashboard/admin', function () {
    return view('dashboards.admin');
})->name('admin.dashboard');

