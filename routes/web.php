<?php

use App\Http\Controllers\AdminProfileController;
use App\Http\Controllers\User\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['auth', 'verified'])->group(function () {

    Route::get('/dashboard', [UserController::class, 'dashboard'])->name('dashboard');

    //User Profile
    Route::get('/user/profile', [UserController::class, 'userProfile'])->name('user.profile');
    Route::post('/user/profile/update', [UserController::class, 'userProfileUpdate'])->name('user.profile.update');

    //User Password
    Route::get('/user/password', [UserController::class, 'userPasswordPage'])->name('user.password.page');
    Route::post('/user/password/update/submit', [UserController::class, 'userPasswordUpdateSubmit'])->name('user.password.update.submit');

});


Route::middleware(['auth:admin', 'verified'])->group(function () {

    //Admin Profile
    Route::get('/admin/profile', [AdminProfileController::class, 'AdminProfile'])->name('admin.profile');
    Route::post('/admin/profile/update', [AdminProfileController::class, 'AdminProfileUpdate'])->name('admin.profile.update');

    //Admin Password
    Route::get('/admin-password', [AdminProfileController::class, 'AdminPasswordPage'])->name('admin.password.page');
    Route::post('/admin/password/update/submit', [AdminProfileController::class, 'AdminPasswordUpdateSubmit'])->name('admin.password.update.submit');

});

require __DIR__ . '/auth.php';
require __DIR__ . '/admin.php';
require __DIR__ . '/frontend.php';
