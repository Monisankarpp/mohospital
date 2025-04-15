<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\ProfileController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;

use App\Http\Controllers\Patient\{
    DashboardController as PatientDashboardController,
    ProfileController as PatientProfileController,
    AppointmentController as PatientAppointmentController,
    PrescriptionController as PatientPrescriptionController,
    PaymentController as PatientPaymentController
};

use App\Http\Controllers\Doctor\{
    DashboardController as DoctorDashboardController,
    ProfileController as DoctorProfileController,
    AppointmentController as DoctorAppointmentController,
    PrescriptionController as DoctorPrescriptionController,
    PaymentLinkController as DoctorPaymentLinkController
};

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

// --------------------
// Patient Routes
// --------------------
Route::middleware(['role:patient'])->prefix('patient')->name('patient.')->group(function () {
    Route::get('/dashboard', [PatientDashboardController::class, 'index'])->name('dashboard');
    Route::controller(PatientProfileController::class)->group(function () {
        Route::get('/profile', 'index')->name('profile');
        Route::post('/profile/update', 'update')->name('profile.update');
    });
    Route::get('/appointments', [PatientAppointmentController::class, 'index'])->name('appointments.book');
    Route::get('/prescription/{id}', [PatientPrescriptionController::class, 'show'])->name('prescriptions.show');
    Route::get('/prescriptions', [PatientPrescriptionController::class, 'index'])->name('prescriptions');
    Route::get('/payments', [PatientPaymentController::class, 'index'])->name('payments');
});

// --------------------
// Doctor Routes
// --------------------
Route::middleware(['role:doctor'])->prefix('doctor')->name('doctor.')->group(function () {
    Route::get('/dashboard', [DoctorDashboardController::class, 'index'])->name('dashboard');
    Route::controller(DoctorProfileController::class)->group(function () {
        Route::get('/profile', 'index')->name('profile');
        Route::post('/profile/update', 'update')->name('profile.update');
    });
    Route::get('/appointments', [DoctorAppointmentController::class, 'index'])->name('appointments');
    Route::get('/prescription-upload', [DoctorPrescriptionController::class, 'index'])->name('prescription.upload');
    Route::post('/prescription-upload', [DoctorPrescriptionController::class, 'store'])->name('prescription.store');

    Route::get('/send-payment-link', [DoctorPaymentLinkController::class, 'index'])->name('payment.link');
});


