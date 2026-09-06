<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\EmployeeController;

// Week 2 - Student API
Route::get('/students', function () {
    return response()->json([
        [
            'id' => 1,
            'name' => 'Juan Dela Cruz',
            'course' => 'BSIT',
        ],
        [
            'id' => 2,
            'name' => 'Maria Santos',
            'course' => 'BSIT',
        ],
    ]);
});

// Week 6 - Public Authentication Routes
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// Week 6 - Protected Routes
Route::middleware('auth:sanctum')->group(function () {

    Route::get('/user', function (Request $request) {
        return response()->json($request->user());
    });

    Route::post('/logout', [AuthController::class, 'logout']);

    // Protected Employee API
    Route::get('/employees', [EmployeeController::class, 'index']);
    Route::post('/employees', [EmployeeController::class, 'store']);
    Route::get('/employees/{id}', [EmployeeController::class, 'show']);
    Route::put('/employees/{id}', [EmployeeController::class, 'update']);
    Route::delete('/employees/{id}', [EmployeeController::class, 'destroy']);
});