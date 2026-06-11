<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller as LaravelBaseController;

class BaseController extends LaravelBaseController
{
    protected function successRedirect($route, $message)
    {
        return redirect()
            ->route($route)
            ->with('success', $message);
    }

    protected function errorRedirect($message)
    {
        return back()->with('error', $message);
    }

    protected function generateCode($prefix)
    {
        return $prefix . date('YmdHis');
    }
}
