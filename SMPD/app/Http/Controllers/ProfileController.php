<?php

namespace App\Http\Controllers;

use App\Models\Member;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Routing\Controller as BaseController;

class ProfileController extends BaseController
{
    public function index()
    {
        $member = Member::with('role')
            ->findOrFail(
                session('member_id')
            );

        return view(
            'anggota.profile.index',
            compact('member')
        );
    }

    public function edit()
    {
        $member = Member::findOrFail(
            session('member_id')
        );

        return view(
            'anggota.profile.edit',
            compact('member')
        );
    }

    public function update(Request $request)
    {
        $member = Member::findOrFail(
            session('member_id')
        );

        $request->validate([

            'name' => 'required|string|max:255',

            'phone' => 'nullable|string|max:20',

            'address' => 'nullable|string|max:1000',

            'password' => 'nullable|confirmed|min:6',

        ]);

        /*
    |--------------------------------------------------------------------------
    | UPDATE DATA PROFIL
    |--------------------------------------------------------------------------
    */

        $member->name = $request->name;

        $member->phone = $request->phone;

        $member->address = $request->address;

        /*
    |--------------------------------------------------------------------------
    | UPDATE PASSWORD
    |--------------------------------------------------------------------------
    */

        if ($request->filled('password')) {

            if (
                !Hash::check(
                    $request->current_password,
                    $member->password
                )
            ) {

                return back()
                    ->withErrors([
                        'current_password' =>
                        'Password lama tidak sesuai.'
                    ])
                    ->withInput();
            }

            $member->password = Hash::make(
                $request->password
            );
        }

        $member->save();

        session([
            'username' => $request->name
        ]);

        return redirect()
            ->route('profile.index')
            ->with(
                'success',
                'Profil berhasil diperbarui.'
            );
    }
}
