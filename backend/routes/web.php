<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DoctorsController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('api/tests', [DoctorsController::class, 'test']);
