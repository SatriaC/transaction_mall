<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\BoardingHouseController;
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
    Route::post('register/user', [AuthController::class, 'user'])->name('register.user');
    Route::post('register/owner', [AuthController::class, 'owner'])->name('register.owner');
});


Route::group(['prefix' => 'boarding-house'], function () {
    Route::get('/', [BoardingHouseController::class, 'index'])->name('boarding.index');
    Route::get('/{id}', [BoardingHouseController::class, 'show'])->name('boarding.show');
});
Route::group(['middleware' => 'auth:api'], function () {
    Route::group(['prefix' => 'boarding-house'], function () {
        Route::post('/add', [BoardingHouseController::class, 'store'])->name('boarding.store');
        Route::get('/{id}/availability', [BoardingHouseController::class, 'availability'])->name('boarding.availability');
        Route::post('/{id}/update', [BoardingHouseController::class, 'update'])->name('boarding.update');
        Route::post('/{id}/delete', [BoardingHouseController::class, 'destroy'])->name('boarding.delete');
    });

    Route::group(['prefix' => 'auth'], function () {
        Route::post('logout', [AuthController::class, 'logout']);
    });
});
