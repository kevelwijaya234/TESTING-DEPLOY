<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Role;
use App\Models\Permission;
use App\Models\RolePermission;

class PermissionController extends Controller
{
    public function index(Request $request)
    {
        $roles = Role::all();

        $selectedRole =
            $request->role
            ??
            Role::first()?->id;

        $permissions =
            Permission::all();

        $rolePermissions =
            RolePermission::where(
                'role_id',
                $selectedRole
            )->get();

        return view(
            'admin.permissions.index',
            compact(
                'roles',
                'permissions',
                'rolePermissions',
                'selectedRole'
            )
        );
    }

    public function update(Request $request)
    {
        $roleId =
            $request->role_id;

        foreach (
            Permission::all()
            as $permission
        ) {

            RolePermission::updateOrCreate(

                [

                    'role_id' =>
                    $roleId,

                    'permission_id' =>
                    $permission->id,

                ],

                [

                    'can_view' =>
                    isset(
                        $request->permissions[$permission->id]['can_view']
                    ),

                    'can_create' =>
                    isset(
                        $request->permissions[$permission->id]['can_create']
                    ),

                    'can_edit' =>
                    isset(
                        $request->permissions[$permission->id]['can_edit']
                    ),

                    'can_delete' =>
                    isset(
                        $request->permissions[$permission->id]['can_delete']
                    ),

                    'can_print' =>
                    isset(
                        $request->permissions[$permission->id]['can_print']
                    ),

                    'can_export' =>
                    isset(
                        $request->permissions[$permission->id]['can_export']
                    ),

                ]
            );
        }

        return redirect()
            ->back()
            ->with(
                'success',
                'Hak akses berhasil diperbarui.'
            );
    }
}
