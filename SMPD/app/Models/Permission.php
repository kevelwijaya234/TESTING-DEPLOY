<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    protected $fillable = [
        'name',
        'slug'
    ];

    public function roles()
    {
        return $this->belongsToMany(
            Role::class,
            'role_permissions'
        )
            ->withPivot([
                'can_view',
                'can_create',
                'can_edit',
                'can_delete',
                'can_print',
                'can_export'
            ]);
    }
}
