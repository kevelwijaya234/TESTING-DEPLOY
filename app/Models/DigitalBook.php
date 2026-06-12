<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DigitalBook extends Model
{
    protected $fillable = [
        'category_id',
        'title',
        'author',
        'kode_buku',
        'publisher',
        'year',
        'isbn',
        'description',
        'file',
        'access',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
