<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\DigitalBook;

class Reservation extends Model
{
    protected $fillable = [
        'reservation_code',
        'member_id',
        'book_id',
        'digital_book_id',
        'book_type',
        'reservation_date',
        'access_until',
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

    public function digitalBook()
    {
        return $this->belongsTo(
            DigitalBook::class
        );
    }
}
