<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\TransactionController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::group(['prefix' => 'auth'], function () {
    Route::post('login', [AuthController::class, 'login'])->name('login');
    Route::post('register', [AuthController::class, 'register'])->name('register');
});

Route::group(['middleware' => 'auth:api'], function () {
    Route::group(['prefix' => 'boarding'], function () {
        Route::get('/{id}', [TransactionController::class, 'show'])->name('boarding.show');
        Route::post('/add', [TransactionController::class, 'store'])->name('boarding.store');
    });

    Route::group(['prefix' => 'auth'], function () {
        Route::post('logout', [AuthController::class, 'logout']);
    });
});
