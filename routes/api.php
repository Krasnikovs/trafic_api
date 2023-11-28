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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/info', function () {
    phpinfo();
});

Route::post('/register', [AuthController::class, 'register']);

Route::apiResource('/users', UserController::class);

Route::apiResource('/vehicle', VehicleController::class);

Route::get('/vehicle_stat', [VehicleController::class, 'avgLifetime']);

Route::post('/get_vehicle', [GraphController::class, 'input']);
