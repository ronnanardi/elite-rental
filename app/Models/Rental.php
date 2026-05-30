<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rental extends Model
{
    protected $fillable = [
        'user_id',
        'unit_id',
        'duration_minutes',
        'total_price',
        'activation_code',
        'status',
        'activated_at',
        'ends_at',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }
}
