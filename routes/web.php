<?php

use App\Http\Controllers\ClientController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\QuotaController;
use App\Http\Controllers\EventController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return redirect()->route('login');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', function () {
        return redirect()->route('clients.index');
    })->name('dashboard');

    // Clients
    Route::resource('clients', ClientController::class);
    Route::post('/clients/{client}/toggle', [ClientController::class, 'toggleStatus'])->name('clients.toggle');

    // Quotas
    Route::resource('quotas', QuotaController::class)->except(['create', 'edit', 'show']);

    // Events
    Route::get('/events', [EventController::class, 'index'])->name('events.index');

    // Users (Admin only)
    Route::middleware(['admin'])->group(function () {
        Route::resource('users', UserController::class);
    });

    // Settings (Placeholder)
    Route::get('/settings', function () {
        return view('settings');
    })->name('settings');

    // API Documentation
    Route::get('/api-doc', function () {
        return view('api-doc');
    })->name('api-doc');

    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
