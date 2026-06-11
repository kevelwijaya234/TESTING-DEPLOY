<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReturnBook extends Model
{
    protected $fillable = [
        'return_code',
        'loan_id',
        'return_date',
        'late_days',
        'fine_amount',
    ];

    public function loan()
    {
        return $this->belongsTo(Loan::class);
    }
}