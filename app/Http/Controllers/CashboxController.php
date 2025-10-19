<?php

namespace App\Http\Controllers;

use App\Models\Revenue;
use App\Models\Expense;
use App\Models\Installment;
use Illuminate\Http\Request;

class CashboxController extends Controller
{
    public function index(Request $request)
    {
        $month = $request->month ?? now()->month;
        $year  = $request->year ?? now()->year;

        // الإيرادات
        $revenues = Revenue::whereYear('date', $year)
                           ->whereMonth('date', $month)
                           ->get();

        // المصروفات
        $expenses = Expense::whereYear('date', $year)
                           ->whereMonth('date', $month)
                           ->get();

        // الإجماليات
        $totalRevenues = $revenues->sum('amount');
        $totalExpenses = $expenses->sum('amount');
        $balance = $totalRevenues - $totalExpenses;

        // الإيرادات المتوقعة (الأقساط المستحقة)
        $expectedInstallments = Installment::whereYear('due_date', $year)
            ->whereMonth('due_date', $month)
            ->where('status', '!=', 'paid')
            ->sum('amount');

        // التنبيهات
        $overdueInstallments = Installment::where('status', '!=', 'paid')
            ->whereDate('due_date', '<', now())
            ->get();

        $todayInstallments = Installment::where('status', '!=', 'paid')
            ->whereDate('due_date', now()->toDateString())
            ->get();

        $upcomingInstallments = Installment::where('status', '!=', 'paid')
            ->whereBetween('due_date', [now()->addDay(), now()->addWeek()])
            ->get();

        // الرسم البياني
        $monthlyRevenues = Revenue::selectRaw('MONTH(date) as month, SUM(amount) as total')
            ->whereYear('date', $year)
            ->groupBy('month')
            ->pluck('total','month');

        $monthlyExpenses = Expense::selectRaw('MONTH(date) as month, SUM(amount) as total')
            ->whereYear('date', $year)
            ->groupBy('month')
            ->pluck('total','month');

        // دمج الحركة المالية كـ Models
        $transactions = $revenues->map(function ($r) {
            $r->transaction_type = 'revenue';
            return $r;
        })->merge(
            $expenses->map(function ($e) {
                $e->transaction_type = 'expense';
                return $e;
            })
        )->sortByDesc('date');

        return view('cashbox.index', compact(
            'month','year',
            'totalRevenues','totalExpenses','balance',
            'expectedInstallments',
            'transactions',
            'monthlyRevenues','monthlyExpenses',
            'overdueInstallments','todayInstallments','upcomingInstallments'
        ));
    }
}
