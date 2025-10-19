<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;     
use App\Models\CashboxTransaction;

class Revenue extends Model
{
    protected $casts = [
        'date' => 'datetime',
    ];
    protected $fillable = [
    'description',
    'amount',
    'date',
    'source_type',
    'source_id',
    'notes',
    'created_by'
];


    public function cashboxTransactions()
    {
        return $this->morphMany(CashboxTransaction::class, 'source');
    }
}
