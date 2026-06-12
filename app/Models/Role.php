<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $fillable = [
        'name'
    ];

    public function members()
    {
        return $this->hasMany(
            Member::class
        );
    }

    public function permissions()
    {
        return $this->belongsToMany(
            Permission::class,
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
    public function rolePermissions()
    {
        return $this->hasMany(
            RolePermission::class
        );
    }
}
