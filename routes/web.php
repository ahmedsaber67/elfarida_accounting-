<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\InstallmentController;
use App\Http\Controllers\UnitController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\CashboxController;
use App\Http\Controllers\AdvanceController;

Route::get('/', function () {
    return redirect()->route('sales.index');
});


Route::resource('sales', SaleController::class);

Route::get('/sales', [App\Http\Controllers\SaleController::class, 'index'])->name('sales.index');

Route::resource('installments', InstallmentController::class)->only(['index', 'edit', 'update']);


Route::patch('/installments/{installment}/pay', [InstallmentController::class, 'markAsPaid'])
    ->name('installments.pay');


Route::patch('/installments/{installment}/pay', [InstallmentController::class, 'pay'])
    ->name('installments.pay');

route::resource('units', UnitController::class);

Route::resource('cashbox', CashboxController::class);

Route::resource('clients', ClientController::class);

Route::resource('expenses', ExpenseController::class);

Route::resource('revenues', \App\Http\Controllers\RevenueController::class);

Route::get('dashboard', [App\Http\Controllers\DashboardController::class, 'index'])->name('dashboard.index');
Route::resource('advances', AdvanceController::class)->except(['show', 'edit', 'update', 'destroy']);
Route::patch('advances/{advance}/close', [AdvanceController::class, 'close'])->name('advances.close');
