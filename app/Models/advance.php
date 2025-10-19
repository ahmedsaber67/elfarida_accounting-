<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Advance extends Model
{
    protected $fillable = ['title', 'amount', 'recipient', 'notes', 'status', 'date'];

    public function closeAdvance($totalCost, $extraPayment = 0)
    {
        // تسجيل المصروف
        Expense::create([
            'description' => 'تصفية عهدة: ' . $this->title,
            'amount' => $totalCost,
            'date' => now(),
            'category' => 'other',
            'notes' => 'العهدة كانت: ' . $this->amount . ' + دفعات إضافية: ' . $extraPayment,
            'created_by' => 1, // هنربطها باليوزر بعدين
        ]);

        // تحديث حالة العهدة
        $this->update(['status' => 'closed']);
    }
}
