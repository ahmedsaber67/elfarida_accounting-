<?php
namespace App\Http\Controllers;
use App\Models\Revenue;
use Illuminate\Http\Request;

class RevenueController extends Controller
{
    public function index(Request $request)
{
    $query = Revenue::query();

    // لو فيه كلمة بحث
    if ($request->filled('search')) {
        $search = $request->search;
        $query->where(function ($q) use ($search) {
            $q->where('description', 'like', "%{$search}%")
              ->orWhere('notes', 'like', "%{$search}%")
              ->orWhere('amount', 'like', "%{$search}%");
        });
    }

    // فلترة بالشهر والسنة
    if ($request->filled('month') && $request->filled('year')) {
        $query->whereMonth('date', $request->month)
              ->whereYear('date', $request->year);
    }

    // اجلب النتائج
    $revenues = $query->orderBy('date', 'desc')->paginate(10);

    // مجموع الشهر الحالي
    $monthlyTotal = Revenue::whereMonth('date', now()->month)
                           ->whereYear('date', now()->year)
                           ->sum('amount');

    return view('revenues.index', compact('revenues', 'monthlyTotal'));
}


    public function create()
    {
        return view('revenues.create');
    }

    public function store(Request $request)
{
    $request->validate([
        'amount' => 'required|numeric|min:0',
        'date'   => 'required|date',
        'notes'  => 'nullable|string|max:500',
    ]);

    Revenue::create([
        'description' => 'إيراد يدوي',
        'amount'      => $request->amount,
        'date'        => $request->date,
        'notes'       => $request->notes,
        'source_type' => 'other',
        'created_by' => auth()->id() ?? 1,
    ]);

    return redirect()->route('revenues.index')->with('success', 'تمت إضافة الإيراد بنجاح');
}



        // عرض فورم التعديل
        public function edit(Revenue $revenue)
        {
            return view('revenues.edit', compact('revenue'));
        }

        // تحديث البيانات
       public function update(Request $request, Revenue $revenue)
{
    $request->validate([
        'amount' => 'required|numeric|min:0',
        'date'   => 'required|date',
        'notes'  => 'nullable|string|max:500',
    ]);

    $revenue->update($request->only('amount','date','notes'));

    return redirect()->route('revenues.index')->with('success', 'تم تحديث الإيراد بنجاح');
}

}
