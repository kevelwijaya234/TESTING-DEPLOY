<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RolePermission extends Model
{
    protected $fillable = [

        'role_id',

        'permission_id',

        'can_view',

        'can_create',

        'can_edit',

        'can_delete',

        'can_print',

        'can_export',
    ];
}
