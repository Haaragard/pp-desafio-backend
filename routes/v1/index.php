<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\PersonController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::prefix('person')->name('.person')->group(function () {
    Route::post('/', [PersonController::class, 'store'])->name('.create');
});

Route::prefix('company')->name('.company')->group(function () {
    Route::post('/', [CompanyController::class, 'store'])->name('.create');
});

Route::prefix('account')->name('.account')->middleware('auth:sanctum')->group(function () {
    Route::post('/deposit', [AccountController::class, 'deposit'])->name('.deposit');
});

Route::prefix('user')->name('.user')->group(function () {
    Route::post('/login', [UserController::class, 'login'])->name('.login');
});
