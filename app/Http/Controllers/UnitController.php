<?php

namespace App\Http\Controllers;
use App\Models\Unit;
use Illuminate\Http\Request;

class UnitController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
{
    $query = Unit::query();

    // بحث بالاسم أو الحالة
    if ($request->filled('search')) {
        $search = $request->search;
        $query->where(function($q) use ($search) {
            $q->where('name', 'like', "%$search%")
              ->orWhere('status', 'like', "%$search%");
        });
    }

    // فلتر حسب الحالة
    if ($request->filled('status')) {
        $query->where('status', $request->status);
    }

    $units = $query->latest()->paginate(10);

    return view('units.index', compact('units'));
}


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('units.create');
    }

    /**
     * Store a newly created resource in storage.
     */
   public function store(Request $request)
{
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'total_price' => 'required|numeric|min:0',
        'status' => 'required|in:idle,reserved,reserved_with_deposit,sold',
    ]);

    Unit::create($validated);

    return redirect()->route('units.index')->with('success', 'تمت إضافة الوحدة بنجاح ✅');
}


    /**
     * Display the specified resource.
     */
    public function show(Unit $unit)
    {
        return view('units.show', compact('unit'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Unit $unit)
    {
          return view('units.edit', compact('unit'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Unit $unit)
{
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'total_price' => 'required|numeric|min:0',
        'status' => 'required|in:idle,reserved,reserved_with_deposit,sold',
    ]);

    $unit->update($validated);

    return redirect()->route('units.index')->with('success', 'تم تحديث بيانات الوحدة ✅');
}
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Unit $unit)
    {
        $unit->delete();
        return redirect()->route('units.index')->with('success', '🗑️ تم حذف الوحدة بنجاح');
    }
}
