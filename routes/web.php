<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\InstallmentController;
use App\Http\Controllers\UnitController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\CashboxController;
use App\Http\Controllers\AdvanceController;
// الصفحة الرئيسية (ممكن تبقى Dashboard بسيط)
Route::get('/', function () {
    return redirect()->route('sales.index');
});

// Sales routes
Route::resource('sales', SaleController::class);

Route::get('/sales', [App\Http\Controllers\SaleController::class, 'index'])->name('sales.index');
// Installments routes
Route::resource('installments', InstallmentController::class)->only(['index', 'edit', 'update']);

// إضافة هذا السطر لتوجيه طلب الدفع إلى الدالة الصحيحة في InstallmentController
Route::patch('/installments/{installment}/pay', [InstallmentController::class, 'markAsPaid'])
    ->name('installments.pay');

// web.php
Route::patch('/installments/{installment}/pay', [InstallmentController::class, 'pay'])
    ->name('installments.pay');

route::resource('units', UnitController::class);

Route::resource('cashbox', CashboxController::class);

// routes/web.php
Route::resource('clients', ClientController::class);

Route::resource('expenses', ExpenseController::class);

Route::resource('revenues', \App\Http\Controllers\RevenueController::class);

Route::get('dashboard', [App\Http\Controllers\DashboardController::class, 'index'])->name('dashboard.index');
Route::resource('advances', AdvanceController::class)->except(['show', 'edit', 'update', 'destroy']);
Route::patch('advances/{advance}/close', [AdvanceController::class, 'close'])->name('advances.close');
