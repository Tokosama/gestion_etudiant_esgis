<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UEController;
use App\Http\Controllers\EcController;

Route::get('/', function () {
    return view('welcome');
});
Route::resource('ues', UEController::class);
Route::resource('ecs', EcController::class);