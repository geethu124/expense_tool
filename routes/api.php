<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Expense;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:api')->group(function () {

    Route::get('/expenses', [ExpenseController::class, 'index']);
    Route::get('/expenses/{id}', [ExpenseController::class, 'show']);
});

