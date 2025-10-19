<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CashboxTransaction extends Model
{
    
   protected $casts = [
    'sale_date' => 'datetime',
];
    
    protected $fillable = ['type', 'amount', 'balance_after', 'notes', 'transaction_date', 'source_type', 'source_id', 'created_by'];

    public function source()
    {
        return $this->morphTo();
    }
}
