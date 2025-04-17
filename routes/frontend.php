<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Admin\Auth\AuthenticatedSessionController;

// Route::get('/', [HomeController::class, 'homePage'])->name('homePage');
Route::get('/', [AuthenticatedSessionController::class, 'create'])->name('login');




