<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BilletController;
use App\Http\Controllers\DocController;
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
