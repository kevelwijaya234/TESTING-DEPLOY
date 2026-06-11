<?php


namespace App\Http\Controllers;

use Illuminate\Http\Request;

abstract class Controller extends BaseController
{
    public function login()
    {
        return view('auth.login');
    }

    public function register()
    {
        return view('auth.register');
    }

    public function dashboard()
    {
        return view('dashboard.index');
    }

    public function logout()
    {
        return redirect()->route('login');
    }
}
