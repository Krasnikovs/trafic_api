<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\GraphController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\VehicleController;
use App\Models\User;
use App\Models\Graph;
use App\Models\Vehicle;

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

Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('/users', UserController::class);
    Route::get('/logout', [AuthController::class, 'logout']);
    Route::get('/me', [AuthController::class, 'me']);
    Route::get('/exportVehicleFilter', [VehicleController::class, 'exportVehicleFilter']);
    Route::get('/exportAvgLifeTime', [VehicleController::class, 'exportAvgLifeTime']);
});

Route::post('/register', [AuthController::class, 'register']);

Route::post('/login', [AuthController::class, 'login']);

Route::post('/vehicle/filter', [VehicleController::class, 'vehicleFilter']);

Route::apiResource('/vehicles', VehicleController::class);

Route::get('/vehicle_timeframe', [VehicleController::class, 'timeframes']);

Route::post('/vehicle/set_vehicle', [VehicleController::class, 'input']);

Route::post('/vehicle/placesBeen', [VehicleController::class, 'placesBeen']);

Route::get('/vehicle/timeSpent', [VehicleController::class, 'avgLifetime']);

Route::get('/pdf_exportVehicleFilter', [VehicleController::class, 'pdfExportVehicleFilter'])->name('pdfExportVehicleFilter');

Route::get('/pdf_exportAvgLifeTime', [VehicleController::class, 'pdfExportAvgLifeTime'])->name('pdfExportAvgLifeTime');