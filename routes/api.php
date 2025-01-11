<?php

use App\Http\Controllers\Api\DivisionController;
use App\Http\Controllers\Api\EmployeeController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\LoginController;
use App\Http\Controllers\Api\LogoutController;
use App\Http\Controllers\Api\Nilai;

/**
 * route "/login"
 * @method "POST"
 */
Route::post('/login', LoginController::class)->name('login');

/**
 * route "/user"
 * @method "GET"
 */
Route::middleware('auth:api')->group(function () {
    Route::apiResource('/divisions', DivisionController::class);
    Route::apiResource('/employees', EmployeeController::class);
});

Route::post('/logout', LogoutController::class)->name('logout');

Route::get('/nilaiRT', [Nilai::class, 'nilaiRT']);
Route::get('/nilaiST', [Nilai::class, 'nilaiST']);