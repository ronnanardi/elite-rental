<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PriceSlot extends Model
{
    protected $fillable = ['unit_id', 'type', 'value', 'price'];

    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }
}
