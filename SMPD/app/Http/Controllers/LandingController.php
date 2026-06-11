<?php

namespace App\Http\Controllers;
use Illuminate\Routing\Controller as BaseControllers;

class LandingController extends BaseControllers
{
    public function index()
    {
        return view('landing');
    }
}