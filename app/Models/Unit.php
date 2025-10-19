<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Unit extends Model
{
    
    protected $fillable = ['name', 'status', 'total_price', 'description'];

    public function sale()
    {
        return $this->hasOne(Sale::class);
    }
}

