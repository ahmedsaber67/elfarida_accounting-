<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSaleRequest;
use App\Models\Sale;
use App\Models\Unit;
use App\Models\Client;
use Illuminate\Http\Request;    


class SaleController extends Controller
{
    // عرض كل المبيعات
   public function index(Request $request)
{
    $query = Sale::with(['client', 'unit']);

    if ($request->filled('search_type') && $request->filled('search_value')) {
        $type = $request->search_type;
        $value = $request->search_value;

        if ($type === 'client_name') {
            $query->whereHas('client', function ($q) use ($value) {
                $q->where('name', 'like', "%$value%");
            });
        } elseif ($type === 'client_phone') {
            $query->whereHas('client', function ($q) use ($value) {
                $q->where('phone', 'like', "%$value%");
            });
        } elseif ($type === 'unit') {
            $query->whereHas('unit', function ($q) use ($value) {
                $q->where('name', 'like', "%$value%");
            });
        }
    }

    $sales = $query->latest()->paginate(10);

    return view('sales.index', compact('sales'));
}


    // عرض فورم إنشاء بيع جديد
    public function create()
    {
        $units = Unit::where('status', 'idle')->get();
        $clients = Client::all();
        return view('sales.create', compact('units', 'clients'));
    }

    // تخزين البيع + إنشاء الأقساط
   public function store(StoreSaleRequest $request)
{
    // بيانات جاية من الفورم بعد التحقق
    $data = $request->validated();
    // الوحدة اللي هتتباع
    $unit = Unit::findOrFail($data['unit_id']);
    // حساب المتبقي تلقائي
    $total_price = $unit->total_price;
    $remaining = $total_price - $data['down_payment'];

    // تسجيل البيع
    $sale = Sale::create([
        'client_id'        => $data['client_id'],
        'unit_id'          => $data['unit_id'],
        'down_payment'     => $data['down_payment'],
        'total_price'      => $total_price,
        'remaining_amount' => $remaining,
        'sale_date'        => $data['sale_date'] ?? now(),
    ]);

    // إنشاء الأقساط لو اليوزر اختار تواريخ
    if (!empty($data['installment_dates'])) {
        foreach ($data['installment_dates'] as $date) {
            $sale->installments()->create([
                'amount'    => $remaining / count($data['installment_dates']),
                'due_date'  => $date,
                'status'    => 'pending',
                'notes'     => null,
                
            ]);
        }
        // حدّث حالة الوحدة
        $unit->update(['status' => 'reserved_with_deposit']);

        
    }

    return redirect()->route('sales.index')->with('success', 'تم تسجيل عملية البيع وإنشاء الأقساط بنجاح');
}

    // عرض عملية بيع واحدة
    public function show(Sale $sale)
    {
        $sale->load('client', 'unit', 'installments');
        return view('sales.show', compact('sale'));
    }

    
    // حذف البيع
    public function destroy(Sale $sale)
    {
        $sale->delete();
        return redirect()->route('sales.index')->with('success', 'تم حذف عملية البيع بنجاح');
    }
}
