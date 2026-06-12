<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Loan extends Model
{
    protected $fillable = [
        'loan_code',
        'member_id',
        'book_id',
        'digital_book_id',
        'book_type',
        'loan_date',
        'due_date',
        'status',
    ];

    public function member()
    {
        return $this->belongsTo(Member::class);
    }

    public function book()
    {
        return $this->belongsTo(Book::class);
    }

    public function returnBook()
    {
        return $this->hasOne(ReturnBook::class);
    }

    public function fine()
    {
        return $this->hasOne(Fine::class);
    }
}
