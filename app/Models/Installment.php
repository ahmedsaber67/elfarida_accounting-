<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Installment extends Model
{
    protected $fillable = [
        'sale_id',
        'amount',
        'due_date',
        'status',
        'notes',
        'receipt_number',
        'created_by',
        'updated_by'
    ];

    protected $casts = [
        'due_date' => 'datetime', // بيتحول Carbon object تلقائي
    ];

    /*
    |--------------------------------------------------------------------------
    | العلاقات
    |--------------------------------------------------------------------------
    */
    public function sale()
    {
        return $this->belongsTo(Sale::class);
    }

    public function revenues()
    {
        return $this->morphMany(Revenue::class, 'source');
    }

    /*
    |--------------------------------------------------------------------------
    | Booted Event
    |--------------------------------------------------------------------------
    */
    

   protected static function booted()
{
    static::updated(function ($installment) {
        if ($installment->isDirty('status') && $installment->status === 'paid') {
            // 🟢 1. إنشاء إيراد تلقائي
            Revenue::create([
                'description' => 'تحصيل قسط للوحدة (' . $installment->sale->unit->name . ')',
                'amount'      => $installment->amount,
                'date'        => now(),
                'source_type' => 'installment',
                'source_id'   => $installment->id,
                'notes'       => null,
                'created_by'  => 1, // خليها User::id بعد ما تعمل Auth
            ]);

            // 🟢 2. التحقق هل البيع خلص أقساطه
            $installment->sale->checkIfFullyPaid();
        }
    });
}


    /*
    |--------------------------------------------------------------------------
    | Accessors
    |--------------------------------------------------------------------------
    */
    public function getComputedStatusAttribute()
    {
        if ($this->status === 'paid') {
            return 'paid';
        }

        if ($this->due_date->isToday()) {
            return 'due';
        }

        if ($this->due_date->isPast()) {
            return 'overdue';
        }

        return 'pending';
    }
}
