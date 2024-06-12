<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\MedicalRecordsController;
use App\Http\Controllers\PatientsController;
use App\Http\Controllers\AppointmentsController;
use App\Http\Controllers\DoctorsController;
use App\Http\Controllers\DashboardController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');



Route::post('/login', [UserController::class, 'login']);
Route::post('/register', [UserController::class, 'register']);
Route::post('/logout', [UserController::class, 'logout'])->middleware('auth:sanctum');

Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::get('/medical/doctor-patient', [MedicalRecordsController::class, 'getDoctorsPatient']);
    Route::get('/medical-records/ownRecords', [MedicalRecordsController::class, 'show']);
    Route::get('/medical-records', [MedicalRecordsController::class, 'index']);
    Route::put('/medical-records/{id}', [MedicalRecordsController::class, 'update']);
    Route::post('/medical-records', [MedicalRecordsController::class, 'store']);
});

Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::get('/patients', [PatientsController::class, 'index']);
    Route::get('/patients/find/{id}', [PatientsController::class, 'show']);
    Route::post('/patients', [PatientsController::class, 'store']);
    Route::put('/patients/{id}', [PatientsController::class, 'update']);
    Route::delete('/patients/{id}', [PatientsController::class, 'destroy']);
});


Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::get('/doctors', [DoctorsController::class, 'index']);
    Route::get('/doctors/find/{id}', [DoctorsController::class, 'show']);
    Route::post('/doctors', [DoctorsController::class, 'store']);
    Route::put('/doctors/{id}', [DoctorsController::class, 'update']);
    Route::delete('/doctors/{id}', [DoctorsController::class, 'destroy']);
});


Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::get('/appointments', [AppointmentsController::class, 'index']);
    Route::get('/doctors/getAppointments', [AppointmentsController::class, 'showDoctorAppointments']);
    Route::get('/appointments/getOwn', [AppointmentsController::class, 'showPatientAppointments']);
    Route::get('/appointments/available', [AppointmentsController::class, 'show']);
    Route::post('/appointments/book', [AppointmentsController::class, 'store']);
    Route::put('/appointments/{id}', [AppointmentsController::class, 'cancelOwnAppointment']);
});

Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::get('/dashboard/admin', [DashboardController::class, 'adminDashboard']);
    Route::get('/dashboard/doctor', [DashboardController::class, 'doctorDashboard']);
});

