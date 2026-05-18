<?php

use App\Http\Controllers\Admin\EventController;
use App\Http\Controllers\Admin\TicketCategoryController;
use App\Http\Controllers\Admin\PaymentVerificationController;
use App\Http\Controllers\Volunteer\RacePackController;
use App\Http\Controllers\Participant\RegistrationController;
use App\Http\Controllers\DashboardController;

Auth::routes();

// Redirect root ke login
Route::get('/', function () {
    return redirect()->route('login');
});

// Admin routes (hanya auth, pengecekan Gate di dalam controller)
Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('dashboard', [DashboardController::class, 'admin'])->name('dashboard');
    Route::resource('events', EventController::class);
    Route::resource('events.ticket_categories', TicketCategoryController::class)->shallow();
    Route::get('payments', [PaymentVerificationController::class, 'index'])->name('payments.index');
    Route::post('payments/{registration}/approve', [PaymentVerificationController::class, 'approve'])->name('payments.approve');
    Route::post('payments/{registration}/reject', [PaymentVerificationController::class, 'reject'])->name('payments.reject');
});

// Volunteer routes
Route::middleware(['auth'])->prefix('volunteer')->name('volunteer.')->group(function () {
    Route::get('dashboard', [DashboardController::class, 'volunteer'])->name('dashboard');
    Route::get('search', [RacePackController::class, 'search'])->name('search');
    Route::get('preview/{registration}', [RacePackController::class, 'preview'])->name('preview');
    Route::post('confirm/{registration}', [RacePackController::class, 'confirm'])->name('confirm');
    Route::get('pending-packs', [RacePackController::class, 'pendingPacks'])->name('pending-packs');
    Route::get('claimed-packs', [RacePackController::class, 'claimedPacks'])->name('claimed-packs');
});

// Participant routes
Route::middleware(['auth'])->prefix('participant')->name('participant.')->group(function () {
    Route::get('dashboard', [DashboardController::class, 'participant'])->name('dashboard');
    Route::get('select-event', [RegistrationController::class, 'selectEvent'])->name('select-event');
    Route::get('event/{event}/categories', [RegistrationController::class, 'selectCategory'])->name('select-category');
    Route::post('checkout', [RegistrationController::class, 'checkout'])->name('checkout');
    Route::get('registrations', [RegistrationController::class, 'index'])->name('registrations.index');
    Route::get('upload/{registration}', [RegistrationController::class, 'uploadForm'])->name('upload.form');
    Route::post('upload/{registration}', [RegistrationController::class, 'uploadProof'])->name('upload.proof');
    Route::get('download/{registration}', [RegistrationController::class, 'downloadTicket'])->name('download-ticket');
    Route::delete('cancel/{registration}', [RegistrationController::class, 'cancel'])->name('cancel');
});
