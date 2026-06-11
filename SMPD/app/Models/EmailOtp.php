<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmailOtp extends Model
{
    protected $fillable = [

        'member_id',

        'otp',

        'expired_at'

    ];
}
