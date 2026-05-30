<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Unit extends Model
{
    protected $fillable = ['console_type', 'image', 'description', 'total', 'is_open'];

    public function priceSlots()
    {
        return $this->hasMany(PriceSlot::class);
    }

    public function rentals()
    {
        return $this->hasMany(Rental::class);
    }
}
