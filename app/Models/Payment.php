<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
     protected $fillable = [
        'rental_id',
        'proof_image',
        'status',
        'reviewed_by',
        'reviewed_at',
    ];

    public function rental()
    {
        return $this->belongsTo(Rental::class);
    }

    public function reviewer()
    {
        return $this->belongsTo(User::class, 'reviewed_by');
    }
}
