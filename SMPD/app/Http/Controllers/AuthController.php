<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Session;

class AuthController extends BaseController
{
    /*
    |--------------------------------------------------------------------------
    | LOGIN PAGE
    |--------------------------------------------------------------------------
    */

    public function login()
    {
        return view('auth.login');
    }


    /*
    |--------------------------------------------------------------------------
    | LOGIN PROCESS
    |--------------------------------------------------------------------------
    */

    public function loginPost(Request $request)
    {
        $role = $request->input('role', 'anggota');

        Session::put('role', $role);

        $email = $request->email;
        $username = explode('@', $email)[0];

        Session::put(
            'username',
            ucfirst($username)
        );

        if ($role == 'admin') {
            return redirect()->route('admin.dashboard');
        }

        if ($role == 'pustakawan') {
            return redirect()->route('pustakawan.dashboard');
        }

        return redirect()->route('anggota.dashboard');
    }


    /*
    |--------------------------------------------------------------------------
    | REGISTER PAGE
    |--------------------------------------------------------------------------
    */

    public function register()
    {
        return view('auth.register');
    }


    /*
    |--------------------------------------------------------------------------
    | LOGOUT
    |--------------------------------------------------------------------------
    */

    public function logout()
    {
        Session::flush();

        return redirect()
            ->route('login');
    }
}
