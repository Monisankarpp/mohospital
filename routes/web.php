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
use App\Http\Controllers\ChatController;



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
    PatientController as DoctorPatientController,
    SlotController,
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

    Route::get('/appointments/{id}/edit', [PatientAppointmentController::class, 'edit'])->name('appointments.edit');
    Route::post('/appointments/{id}/update', [PatientAppointmentController::class, 'update'])->name('appointments.update');
    Route::get('/appointments/{id}/view', [PatientAppointmentController::class, 'show'])->name('appointments.view');



});

// --------------------
// Doctor Routes
// --------------------

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

        Route::get('/my-patients', [DoctorPatientController::class, 'index'])->name('my-patients');
        Route::post('/slots/unavailable-day', [SlotController::class, 'markUnavailableDay'])->name('slots.unavailable-day');



    });

Route::post('/notifications/{id}/read', [NotificationController::class, 'markAsRead'])->name('notifications.markAsRead');

Route::get('/generate-invoice/{id}', [InvoiceController::class, 'generatePDF'])->name('generate.invoice');

Route::get('/invoice/view/{id}', [InvoiceController::class, 'view'])->name('invoices.show');

Route::get('/', [DoctorController::class, 'index'])->name('doctors.index');

Route::get('/get-available-dates/{doctor}', [App\Http\Controllers\DoctorController::class, 'getAvailableDates']);

Route::post('/appointments/book', [DoctorController::class, 'book'])->name('appointments.book');

Route::middleware('role:patient')->post('/payment/create-intent', [PaymentController::class, 'createPaymentIntent']);
Route::middleware('role:patient')->post('/payment/success', [PaymentController::class, 'paymentSuccess']);

Route::middleware(['doctor.first.login'])->group(function () {
    Route::view('/doctor/first-login', 'doctor.first-login');
});

Route::get('/doctor/message-patient/{patient_id}', [DoctorController::class, 'messagePatient'])
    ->name('doctor.message.patient');

Route::post('/appointment/prepare', [\App\Http\Controllers\AppointmentControllerForID::class, 'prepare']);

// Doctor routes
Route::prefix('doctor')->as('doctor.')->middleware('role:doctor')->group(function () {
    Route::resource('slots', SlotController::class)->except(['show']);
    Route::post('slots/apply-default', [SlotController::class, 'applyDefaultSchedule'])
        ->name('slots.apply-default');
});

Route::post('/notifications/{id}/read', [App\Http\Controllers\NotificationController::class, 'markAsRead'])->name('notifications.read');

Route::post('/api/chat', [ChatController::class, 'chat']);
Route::view('/chat', 'chat');

Route::post('/doctor/appointments/{appointment}/reschedule', [DoctorAppointmentController::class, 'reschedule']);


// In your web.php
Route::get('/doctor/appointments/{appointment}/available-slots', [DoctorAppointmentController::class, 'getAvailableSlots']);


Route::post('/doctor/appointments/{appointment}/complete', [DoctorDashboardController::class, 'complete'])->name('doctor.appointments.complete');


Route::post('/appointments/{id}/reschedule', [PatientDashboardController::class, 'reschedule']);
Route::get('/doctors/{doctor}/available-slots', [PatientDashboardController::class, 'getAvailableSlots']);


Route::get('/notifications/all', [NotificationController::class, 'all'])->name('notifications.all');
Route::get('/notifications/{id}', [NotificationController::class, 'show'])->name('notifications.show');
