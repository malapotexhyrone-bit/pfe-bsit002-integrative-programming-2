<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EmployeeController;

/// Week 2 - Student API
Route::get('/students', function () {
    return response()->json([
        [
            'id' => 1,
            'name' => 'Juan Dela Cruz',
            'course' => 'BSIT'
        ],
        [
            'id' => 2,
            'name' => 'Maria Santos',
            'course' => 'BSIT'
        ]
    ]);
});

// Week 4 - Employee CRUD API
Route::get('/employees', [EmployeeController::class, 'index']);

Route::post('/employees', [EmployeeController::class, 'store']);

Route::get('/employees/{id}', [EmployeeController::class, 'show']);

Route::put('/employees/{id}', [EmployeeController::class, 'update']);

Route::delete('/employees/{id}', [EmployeeController::class, 'destroy']);