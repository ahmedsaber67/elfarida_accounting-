<?php
namespace App\Http\Controllers;
use App\Models\Advance;
use App\Models\Expense;
use Illuminate\Http\Request;


class AdvanceController extends Controller
{
    public function index()
    {
        $advances = Advance::latest()->paginate(10);
        return view('advances.index', compact('advances'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'amount' => 'required|numeric|min:1',
            'recipient' => 'nullable|string|max:255',
            'notes' => 'nullable|string',
        ]);

        Advance::create($request->all());

        return back()->with('success', '✅ تم إضافة عهدة جديدة');
    }

    public function close(Request $request, Advance $advance)
    {
        $request->validate([
            'total_cost' => 'required|numeric|min:1',
            'extra_payment' => 'nullable|numeric|min:0',
        ]);

        $advance->closeAdvance($request->total_cost, $request->extra_payment);

        return back()->with('success', '✅ تم تصفية العهدة وتسجيلها كمصروف');
    }
}
