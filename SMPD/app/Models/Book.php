<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    protected $fillable = [
        'category_id',
        'title',
        'author',
        'publisher',
        'year',
        'isbn',
        'kode_buku',
        'stock',
        'description',
        'cover',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function loans()
    {
        return $this->hasMany(
            Loan::class
        );
    }

    public function reservations()
    {
        return $this->hasMany(
            Reservation::class
        );
    }
}
