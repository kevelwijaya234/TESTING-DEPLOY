<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Fine extends Model
{
    protected $fillable = [
        'loan_id',
        'amount',
        'status',
    ];

    public function loan()
    {
        return $this->belongsTo(Loan::class);
    }
}