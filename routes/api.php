<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\UserController;
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

Route::get('/user_show', [UserController::class, 'show']);

Route::get('/vehicle', [VehicleController::class, 'show']);

Route::get('/vehicle_index', [VehicleController::class, 'index']);

Route::get('/test_mongodb/', function (Request $request) {

    $connection = DB::connection('mongodb');
    $msg = 'Mongo is suc!';
    try {
        $connection->command(['ping' => 1]);
    } catch (\Exception $e) {
        $msg = 'Mongo down:( Error:' . $e->getMessage();
    }

    return ['msg' => $msg];
});

Route::get('/test_postgres/', function (Request $request) {

    $connection = DB::collection('');
    $msg = 'Postgres is suc!';
    try {
        $connection->getDatabaseName();
    } catch (\Exception $e) {
        $msg = 'Postgres down:( Error: ' . $e->getMessage();
    }

    return ['msg' => $msg];
});
