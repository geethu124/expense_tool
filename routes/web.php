<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\ExpenseController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;






Route::get('/', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);

Route::post('/logout', [LoginController::class, 'logout'])->name('logout');




Route::middleware('auth')->group(function(){
    Route::get('/expenses', [ExpenseController::class, 'index'])->name('expenses.index');
    // Route::get('/expenses/create', [ExpenseController::class, 'create'])->name('expenses.create');
    Route::post('/expenses', [ExpenseController::class, 'store'])->name('expenses.store');
    Route::get('/expenses/{expense}/edit', [ExpenseController::class, 'edit'])->name('expenses.edit');
    Route::put('/expenses/{expense}', [ExpenseController::class, 'update'])->name('expenses.update');


});
Route::middleware(['auth'])->group(function () {
    Route::get('/admin/expenses', [AdminController::class, 'index'])->name('admin.dashboard');

Route::get('/expenses/{id}', [AdminController::class, 'show'])->name('expenses.show');
Route::post('/expenses/{id}/approve', [AdminController::class, 'approve'])->name('expenses.approve');
Route::post('/expenses/{id}/reject', [AdminController::class, 'reject'])->name('expenses.reject');


});
