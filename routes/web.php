<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\BotController;

// Public routes
Route::get('/', function () {
    return view('welcome');
});

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::get('/register', [AuthController::class, 'register'])->name('register');
Route::post('/login', [AuthController::class, 'authenticate'])->name('login.authenticate'); 
Route::post('/register', [AuthController::class, 'store'])->name('register.store');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Protected routes
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Bot management routes
    Route::resource('bots', BotController::class)->only(['index', 'create', 'store', 'show', 'destroy']);
    
    // Bot API routes
    Route::post('/bots/{bot}/send-message', [BotController::class, 'sendMessage'])->name('bots.send-message');
    Route::get('/bots/{bot}/updates', [BotController::class, 'getUpdates'])->name('bots.updates');
});

Route::fallback(function () {
    return view('errors.404');
});
