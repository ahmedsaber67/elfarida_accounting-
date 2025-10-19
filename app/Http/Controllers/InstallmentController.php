<?php

namespace App\Http\Controllers;

use App\Models\Installment;
use Illuminate\Http\Request;


class InstallmentController extends Controller
{

     public function markAsPaid(Installment $installment)
    {
        if ($installment->status !== 'paid') {
            $installment->update(['status' => 'paid']);
            
        }

        return redirect()->back()->with('success', 'تم تسجيل دفع القسط بنجاح');
    }
    
   public function edit(Installment $installment)
{
    return view('installments.edit', compact('installment'));
}

public function update(Request $request, Installment $installment)
{
    $request->validate([
        'notes' => 'nullable|string|max:500',
    ]);

    $installment->update(['notes' => $request->notes]);

    return response()->json(['success' => true]);
}
    // ممكن تضيف دوال تانية لو احتجت

    // InstallmentController.php
public function pay(Installment $installment)
{
    $installment->update([
        'status' => 'paid',
        'notes' => 'تم الدفع بتاريخ ' . now()->format('Y-m-d H:i'),
    ]);

    return back()->with('success', '✅ تم تأكيد دفع القسط');
}

}
