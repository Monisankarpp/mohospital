<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\PaymentController;



use App\Http\Controllers\Patient\{
    DashboardController as PatientDashboardController,
    ProfileController as PatientProfileController,
    AppointmentController as PatientAppointmentController,
    PrescriptionController as PatientPrescriptionController,
};

use App\Http\Controllers\Doctor\{
    DashboardController as DoctorDashboardController,
    ProfileController as DoctorProfileController,
    AppointmentController as DoctorAppointmentController,
    PrescriptionController as DoctorPrescriptionController,
    SlotController,
    SlotSetupController,
    ScheduleController,
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
    Route::get('/appointments/{id}', [PatientAppointmentController::class, 'show'])->name('appointments.show');


    Route::get('/prescription/{id}', [PatientPrescriptionController::class, 'show'])->name('prescriptions.show');
    Route::get('/prescriptions', [PatientPrescriptionController::class, 'index'])->name('prescriptions');
});

// --------------------
// Doctor Routes
// --------------------
// Route::middleware(['role:doctor'])->prefix('doctor')->name('doctor.')->group(function () {
//     Route::get('/dashboard', [DoctorDashboardController::class, 'index'])->name('dashboard');
//     Route::controller(DoctorProfileController::class)->group(function () {
//         Route::get('/profile', 'index')->name('profile');
//         Route::post('/profile/update', 'update')->name('profile.update');
//     });
//     Route::get('/appointments', [DoctorAppointmentController::class, 'index'])->name('appointments');
//     Route::get('/prescription-upload', [DoctorPrescriptionController::class, 'index'])->name('prescription.upload');
//     Route::post('/prescription-upload', [DoctorPrescriptionController::class, 'store'])->name('prescription.store');
//     // Route::resource('slots', SlotController::class);
// });

Route::middleware(['role:doctor'])
    ->prefix('doctor')
    ->name('doctor.')
    ->group(function () {
        Route::get('/dashboard', [DoctorDashboardController::class, 'index'])->name('dashboard');

        Route::controller(DoctorProfileController::class)->group(function () {
            Route::get('/profile', 'index')->name('profile');
            Route::post('/profile/update', 'update')->name('profile.update');
        });

        Route::get('/appointments', [DoctorAppointmentController::class, 'index'])->name('appointments');
        Route::get('/appointments/{id}', [DoctorAppointmentController::class, 'show'])->name('appointments.show');


        Route::get('/prescription-upload', [DoctorPrescriptionController::class, 'index'])->name('prescription.upload');
        Route::post('/prescription-upload', [DoctorPrescriptionController::class, 'store'])->name('prescription.store');

    });


Route::post('/notifications/{id}/read', [NotificationController::class, 'markAsRead'])->name('notifications.markAsRead');

Route::get('/generate-invoice/{id}', [InvoiceController::class, 'generatePDF'])->name('generate.invoice');

Route::get('/invoice/view/{id}', [InvoiceController::class, 'view'])->name('invoices.show');



// Route::middleware(['auth'])->group(function () {
Route::get('/', [DoctorController::class, 'index'])->name('doctors.index');
// Route::post('/appointments', [AppointmentController::class, 'store'])->name('appointments.store');
// });

Route::get('/get-available-dates/{doctor}', [App\Http\Controllers\DoctorController::class, 'getAvailableDates']);


Route::post('/appointments/book', [DoctorController::class, 'book'])->name('appointments.book');

// Booking routes
Route::post('/payment/create-intent', [PaymentController::class, 'createIntent'])->name('payment.create-intent');
Route::get('/payment/success', [PaymentController::class, 'success'])->name('payment.success');


// routes/web.php
Route::middleware(['role:doctor'])->prefix('doctor')->name('doctor.')->group(function () {
    // First-time setup
    Route::get('slots/setup', [SlotSetupController::class, 'create'])->name('slots.setup');
    Route::post('slots/setup', [SlotSetupController::class, 'store'])->name('slots.store');

    // Schedule management
    Route::get('schedule', [ScheduleController::class, 'index'])->name('schedule.index');
    Route::get('slots/{slot}/edit', [ScheduleController::class, 'edit'])->name('slots.edit');
    Route::put('slots/{slot}', [ScheduleController::class, 'update'])->name('slots.update');
    Route::delete('slots/{slot}', [ScheduleController::class, 'destroy'])->name('slots.destroy');

    // Schedule reuse confirmation
    Route::post('schedule/confirm', [ScheduleController::class, 'confirmReuseSchedule'])
        ->name('schedule.confirm');
});

// Add this to your auth middleware if you want to check first login
Route::middleware(['doctor.first.login'])->group(function () {
    Route::view('/doctor/first-login', 'doctor.first-login');
});
