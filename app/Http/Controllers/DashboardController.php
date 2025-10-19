<?php

namespace App\Http\Controllers;

use App\Models\Revenue;
use App\Models\Expense;
use App\Models\Installment;
use App\Models\Unit;
use App\Models\Sale;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $month = now()->month;
        $year  = now()->year;

        // إجمالي الإيرادات والمصروفات الشهرية
        $monthlyRevenues = Revenue::whereMonth('date', $month)->whereYear('date', $year)->sum('amount');
        $monthlyExpenses = Expense::whereMonth('date', $month)->whereYear('date', $year)->sum('amount');
        $cashbox = $monthlyRevenues - $monthlyExpenses;

        // إحصائيات الوحدات
        $unitsStats = [
            'idle'     => Unit::where('status', 'idle')->count(),
            'reserved' => Unit::where('status', 'reserved')->count(),
            'sold'     => Unit::where('status', 'sold')->count(),
        ];

                // 🏠 إجمالي الوحدات المباعة
        $soldUnitsTotal = Unit::where('status', 'sold')->count();

        // 🏠 الوحدات المباعة خلال الشهر الحالي
        $soldUnitsMonth = Sale::whereYear('sale_date', $year)
            ->whereMonth('sale_date', $month)
            ->count();

            

        // التنبيهات
        $overdueInstallments = Installment::where('status', '!=', 'paid')
            ->where('due_date', '<', Carbon::today())
            ->get();

        $upcomingInstallments = Installment::where('status', '!=', 'paid')
            ->whereBetween('due_date', [Carbon::today(), Carbon::today()->addDays(7)])
            ->get();

        return view('dashboard.index', compact(
            'monthlyRevenues',
            'monthlyExpenses',
            'soldUnitsTotal',
            'soldUnitsMonth',
            'cashbox',
            'unitsStats',
            'overdueInstallments',
            'upcomingInstallments'
        ));
    }
}
