<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\Member;
use Illuminate\Routing\Controller as BaseController;

class LoginController extends BaseController
{
    public function login()
    {
        return view('auth.login');
    }

    public function authenticate(Request $request)
    {
        $member = Member::with('role')
            ->where(
                'email',
                $request->email
            )
            ->first();

        if (!$member) {

            return back()->with(
                'error',
                'Email atau password salah.'
            );
        }

        if (
            !Hash::check(
                $request->password,
                $member->password
            )
        ) {

            return back()->with(
                'error',
                'Email atau password salah.'
            );
        }

        if (
            $member->role->name === 'anggota'
            &&
            $member->email_verified_at === null
        ) {

            return back()->with(
                'error',
                'Email belum diverifikasi. Silakan verifikasi OTP terlebih dahulu.'
            );
        }

        session([

            'member_id' =>
            $member->id,

            'username' =>
            $member->name,

            'role_id' =>
            $member->role_id,

            'role' =>
            $member->role->name,

        ]);

        switch ($member->role->name) {

            case 'admin':

                return redirect()
                    ->route(
                        'admin.dashboard'
                    );

            case 'pustakawan':

                return redirect()
                    ->route(
                        'pustakawan.dashboard'
                    );

            default:

                return redirect()
                    ->route(
                        'anggota.dashboard'
                    );
        }
    }

    public function logout()
    {
        session()->flush();

        return redirect()
            ->route('login');
    }
}
