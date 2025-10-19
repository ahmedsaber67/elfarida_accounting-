<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    protected $casts = [
    'sale_date' => 'datetime',
];

    protected $fillable = ['client_id','unit_id','total_price','down_payment','remaining_amount','sale_date'];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }

    public function installments()
    {
        return $this->hasMany(Installment::class);
    }
    
    protected static function booted()
    {
        static::created(function ($sale) {
            if ($sale->down_payment > 0) {
                Revenue::create([
                    'description' => 'مقدم للوحدة (' . $sale->unit->name.')' ,
                    'amount'      => $sale->down_payment,
                    'date'        => now(),
                    'source_type' => 'sale',
                    'source_id'   => $sale->id,
                    'created_by'  => auth()->id ?? 1, // مؤقت لو مفيش auth
                ]);
            }
        });
    }

        public function checkIfFullyPaid()
    {
        if ($this->installments()->where('status', '!=', 'paid')->count() === 0) {
            // لو مفيش أقساط غير مدفوعة → الوحدة تعتبر مباعة
            $this->unit->update(['status' => 'sold']);
        }
    }


    public function revenues()
    {
        return $this->morphMany(Revenue::class, 'source');
    }

 public static function createSaleWithInstallments(array $data)
{
    $remaining = $data['total_price'] - ($data['down_payment'] ?? 0);

    $sale = self::create([
        'client_id' => $data['client_id'],
        'unit_id' => $data['unit_id'],
        'sale_date' => now(),
        'total_price' => $data['total_price'],
        'down_payment' => $data['down_payment'] ?? 0,
        'remaining_amount' => $remaining,
        'installments_count' => $data['installments_count'],
    ]);

    // حدّث حالة الوحدة
    $sale->unit->update(['status' => 'reserved_with_deposit']);

    // وزع المبلغ على عدد الأقساط
    $installmentAmount = $remaining / $data['installments_count'];

    foreach ($data['installment_dates'] as $dueDate) {
        $sale->installments()->create([
            'amount' => $installmentAmount,
            'due_date' => $dueDate,
            'status' => 'pending',
        ]);
    }

    return $sale;
}


}
