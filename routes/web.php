<?php

use App\Http\Controllers\Admin\ApplicationController as AdminApplicationController;
use App\Http\Controllers\Admin\CandidateController as AdminCandidateController;
use App\Http\Controllers\Admin\JobController as AdminJobController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ChatbotController;
use App\Http\Controllers\JobApplicationController;
use App\Http\Controllers\JobController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', fn () => redirect()->route('jobs.index'));

// Guest-only auth routes
Route::middleware('guest')->group(function () {
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});

Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');

// Public job browsing (visible to guests, apply requires auth)
Route::get('/jobs', [JobController::class, 'index'])->name('jobs.index');
Route::get('/jobs/{job}', [JobController::class, 'show'])->name('jobs.show');

// Candidate-only routes
Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');

    Route::post('/jobs/{job}/apply', [JobApplicationController::class, 'store'])->name('applications.store');
    Route::delete('/applications/{application}', [JobApplicationController::class, 'destroy'])->name('applications.destroy');
    Route::get('/my-applications', [JobApplicationController::class, 'index'])->name('applications.index');

    Route::post('/chatbot', [ChatbotController::class, 'ask'])->name('chatbot.ask');
});

// Admin-only routes
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::resource('jobs', AdminJobController::class)->except(['show']);
    Route::get('candidates', [AdminCandidateController::class, 'index'])->name('candidates.index');
    Route::get('candidates/{candidate}', [AdminCandidateController::class, 'show'])->name('candidates.show');
    Route::get('applications', [AdminApplicationController::class, 'index'])->name('applications.index');
});