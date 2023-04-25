<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BilletController;
use App\Http\Controllers\DocController;
use App\Http\Controllers\FoundAndLostController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\UnitController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WallController;
use App\Http\Controllers\WarningController;
use App\Models\FoundAndLost;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('ping', function() {
    return ['pong' => true];
});

Route::get('/401', [AuthController::class, 'unauthorized'])->name('login');

Route::post('/auth/login', [AuthController::class, 'login']);
Route::post('/auth/register', [AuthController::class, 'register']);

Route::middleware('auth:api')->group(function(){
    Route::post('/auth/validate', [AuthController::class, 'validatedToken']);
    Route::post('/auth/logout', [AuthController::class, 'logout']);

    //Mural de avisos
    Route::get('/walls', [WallController::class, 'index']);
    Route::post('/wall/{id}/like', [WallController::class, 'like']);

    //Documentos
    Route::get('/docs', [DocController::class, 'index']);

    //Livro de ocorrencias
    Route::get('/warnings', [WarningController::class, 'index']);
    Route::post('//warning', [WarningController::class, 'store']);
    Route::post('//warning/file', [WarningController::class, 'storeFile']);

    //Boletos
    Route::get('/billets', [BilletController::class, 'index']);

    //Achados e perdidos
    Route::get('/foundandlost', [FoundAndLostController::class, 'index']);
    Route::post('/foundandlost', [FoundAndLostController::class, 'store']);
    Route::put('/founandlost/{id}', [FoundAndLostController::class, 'update']);

    //Unidade
    Route::get('/unit/{id}', [UnitController::class, 'show']);
    Route::post('/unit/{id}/addperson', [UnitController::class, 'addPerson']);
    Route::post('/unit/{id}/addvehicle', [UnitController::class, 'addVehicle']);
    Route::post('/unit/{id}/addpet', [UnitController::class, 'addPet']);
    Route::delete('/unit/{id}/removeperson', [UnitController::class, 'removePerson']);
    Route::delete('/unit/{id}/removevehicle', [UnitController::class, 'removeVehicle']);
    Route::delete('/unit/{id}/removepet', [UnitController::class, 'removePet']);

    //Reservas
    Route::get('/reservations', [ReservationController::class, 'getReservations']);
    Route::post('/reservation/{id}', [ReservationController::class, 'setReservation']);

    Route::get('/reservation/{id}/disableddates', [ReservationController::class, 'getDisabledDates']);
    Route::get('/reservation/{id}/times', [ReservationController::class, 'getTimes']);



    Route::get('/myreservations', [ReservationController::class, 'getMyReservations']);
    Route::delete('/myreservation/{id}', [ReservationController::class, 'delMyReservations']);


});

