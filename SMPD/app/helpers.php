<?php

use App\Models\Member;
use App\Models\Permission;
use App\Models\RolePermission;

if (!function_exists(
    'hasPermission'
)) {

    function hasPermission(
        $module,
        $action
    ) {

        $memberId =
            session(
                'member_id'
            );

        if (!$memberId) {

            return false;
        }

        $member =
            Member::find(
                $memberId
            );

        $permission =
            Permission::where(
                'slug',
                $module
            )->first();

        if (
            !$member ||
            !$permission
        ) {

            return false;
        }

        $rolePermission =
            RolePermission::where(
                'role_id',
                $member->role_id
            )
            ->where(
                'permission_id',
                $permission->id
            )
            ->first();

        if (!$rolePermission) {

            return false;
        }

        $column =
            'can_' . $action;

        return
            (bool)
            $rolePermission->$column;
    }
}
