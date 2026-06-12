<?php

namespace App\Http\Controllers;

use App\Models\Member;
use Illuminate\Routing\Controller as BaseController;

class UserController extends BaseController
{
    public function index()
    {
        $users = Member::with('role')
            ->whereHas('role', function ($query) {
                $query->whereIn('name', ['admin', 'pustakawan']);
            })
            ->orderBy('name')
            ->get();

        return view('admin.users.index', compact('users'));
    }
}
