<?php

use App\Http\Controllers\UserController;
use App\Http\Controllers\ParkingController;
use App\Http\Controllers\ReservationController;
use App\Models\Reservation;
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

Route::post('/register', [UserController::class, 'createUser']);
Route::post('/login', [UserController::class, 'loginUser']) ;
Route::post('/logout', [UserController::class, 'logoutUser'])->middleware('auth:sanctum');
Route::post('/parkings/search', [ParkingController::class, 'rechercherParking']);
Route::post('/reservation', [ReservationController::class, 'store'])->middleware("auth:sanctum");
Route::put('/update/{id}', [ReservationController::class, 'modifierReservation']);
Route::delete('/delete/{id}', [ReservationController::class, 'supprimerReservation']);
Route::get('/mes-reservations', [ReservationController::class, 'mesReservations']);

