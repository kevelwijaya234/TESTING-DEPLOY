<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Member;
use App\Models\Permission;
use App\Models\RolePermission;

class CheckPermission
{
    public function handle(
        Request $request,
        Closure $next,
        $module,
        $action
    ) {
        $memberId = session(
            'member_id'
        );

        if (!$memberId) {

            abort(403);
        }

        $member = Member::find(
            $memberId
        );

        $permission = Permission::where(
            'slug',
            $module
        )->first();

        if (
            !$member ||
            !$permission
        ) {

            abort(403);
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

            abort(403);
        }

        $column =
            'can_' . $action;

        if (
            !$rolePermission->$column
        ) {

            abort(403);
        }

        return $next(
            $request
        );
    }
}
