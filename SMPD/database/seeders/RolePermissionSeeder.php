<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Permission;
use App\Models\RolePermission;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        $permissions = Permission::all();

        foreach ($permissions as $permission) {

            // ADMIN
            RolePermission::create([

                'role_id' => 1,

                'permission_id' =>
                $permission->id,

                'can_view' => true,

                'can_create' => true,

                'can_edit' => true,

                'can_delete' => true,

                'can_print' => true,

                'can_export' => true,
            ]);
        }
    }
}
