<?php

use App\Http\Controllers\CustomerController;
use Illuminate\Support\Facades\Route;


Route::prefix('customers')->name('customers.')->group(function () {
    Route::get('/', [CustomerController::class, 'index'])->name('index');
    Route::post('/', [CustomerController::class, 'store'])->name('store');
    Route::get('/{id}', [CustomerController::class, 'show'])->name('show');
    Route::put('/{id}', [CustomerController::class, 'update'])->name('update');
    Route::delete('/{id}', [CustomerController::class, 'destroy'])->name('destroy');
    Route::post('/{id}/restore', [CustomerController::class, 'restore'])->name('restore');
});
