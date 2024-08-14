<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminHomeController;
use App\Http\Controllers\UserHomeController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth','user'])->group(function () {
    Route::get('user/dashboard', [UserHomeController::class, 'index'])->name('user.dashboard');
    // halaman history claim
    Route::get('user/{id}/history', [UserHomeController::class, 'history'])->name('history.claim'); 
    // claim
    Route::post('user/history', [UserHomeController::class, 'claim_voucher'])->name('claim.voucher');  
    // delete
    Route::delete('/history/{id}', [UserHomeController::class, 'claim_delete'])->name('claim.delete');
    // logout
    Route::delete('/user/logout', [UserHomeController::class, 'logout'])->name('user.logout');
});


Route::middleware(['auth','admin'])->group(function () {
    Route::get('admin/dashboard', [AdminHomeController::class, 'index'])->name('admin.dashboard');
    // edit
    Route::get('admin/create_voucher', [AdminHomeController::class, 'create'])->name('voucher.create');
    Route::post('admin/create_voucher/store', [AdminHomeController::class, 'store'])->name('voucher.store');
    // edit
    Route::get('admin/edit_voucher/{id}', [AdminHomeController::class, 'edit'])->name('voucher.edit');
    Route::put('admin/edit_voucher/{id}', [AdminHomeController::class, 'update'])->name('voucher.update');
    // delete
    Route::delete('admin/{id}', [AdminHomeController::class, 'delete'])->name('voucher.delete');
    // logout
    Route::post('/admin/logout', [AdminHomeController::class, 'logout'])->name('admin.logout');
});

require __DIR__.'/auth.php';



