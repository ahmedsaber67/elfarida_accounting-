<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use App\Models\User;
use Illuminate\Http\Request;

class ExpenseController extends Controller
{
    // عرض كل المصروفات
   public function index(Request $request)
{
    $query = Expense::query();

    // فلترة بالشهر والسنة لو المستخدم اختار
    if ($request->filled('month') && $request->filled('year')) {
        $query->whereMonth('date', $request->month)
              ->whereYear('date', $request->year);
    }

    $expenses = $query->orderBy('date', 'desc')->paginate(10);

    // إجمالي الشهر الحالي
    $monthlyTotal = Expense::whereMonth('date', now()->month)
                          ->whereYear('date', now()->year)
                          ->sum('amount');

    return view('expenses.index', compact('expenses', 'monthlyTotal'));
}



    // فورم إنشاء
    public function create()
    {
        return view('expenses.create');
    }

    // تخزين مصروف جديد
    public function store(Request $request)
    {
        $request->validate([
            'description' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0',
            'date' => 'required|date',
            'category' => 'required|in:rent,salaries,maintenance,other',
            'notes' => 'nullable|string',
        ]);
        
        Expense::create([
            'description' => $request->description,
            'amount' => $request->amount,
            'date' => $request->date,
            'category' => $request->category,
            'notes' => $request->notes,
            
        ]);

        return redirect()->route('expenses.index')->with('success', 'تم إضافة المصروف بنجاح ✅');
    }

    // فورم تعديل مصروف
    public function edit(Expense $expense)
    {
        return view('expenses.edit', compact('expense'));
    }
    // تحديث مصروف
    public function update(Request $request, Expense $expense)
    {
        $request->validate([
            'description' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0',
            'date' => 'required|date',
            'category' => 'required|in:rent,salaries,maintenance,other',
            'notes' => 'nullable|string',
        ]); 
        $expense->update($request->all());
        return redirect()->route('expenses.index')->with('success', 'تم تحديث المصروف بنجاح ✏️');
    }
    // حذف مصروف
    public function destroy(Expense $expense)
    {
        $expense->delete();
        return redirect()->route('expenses.index')->with('success', 'تم حذف المصروف بنجاح ❌');
    }
}
