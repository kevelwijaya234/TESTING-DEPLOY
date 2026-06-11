<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
   protected $fillable = [
      'role_id',
      'member_code',
      'name',
      'email',
      'email_verified_at',
      'password',
      'phone',
      'address',
      'status',
   ];

   protected $hidden = [

      'password'
   ];

   // ======================
   // ROLE
   // ======================

   public function role()
   {
      return $this->belongsTo(
         Role::class
      );
   }

   public function emailOtps()
   {
      return $this->hasMany(
         EmailOtp::class
      );
   }
}
