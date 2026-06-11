<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Member;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Routing\Controller as BaseController;

class AuthApiController extends BaseController
{
    public function register(Request $request)
    {
        return response()->json([
            'message' => 'Register API aktif'
        ]);
    }

    public function login(Request $request)
    {
        return response()->json([
            'message' => 'Login API aktif'
        ]);
    }

    public function logout(Request $request)
    {
        return response()->json([
            'message' => 'Logout API aktif'
        ]);
    }
}
