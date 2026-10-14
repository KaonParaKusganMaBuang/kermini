<?php

use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MechanicController;
use App\Http\Controllers\PartController;
use App\Http\Controllers\RepairJobController;
use App\Http\Controllers\VehicleController;
use Illuminate\Support\Facades\Route;

Route::get('/', DashboardController::class)->name('dashboard');
Route::resource('customers', CustomerController::class);
Route::resource('vehicles', VehicleController::class);
Route::resource('mechanics', MechanicController::class);
Route::resource('repair-jobs', RepairJobController::class)->parameters(['repair-jobs' => 'repairJob']);
Route::resource('parts', PartController::class);
