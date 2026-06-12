<?php

namespace App\Http\Controllers;

use App\Models\Member;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Routing\Controller as BaseController;
use App\Models\EmailOtp;
use App\Mail\SendOtpMail;
use Illuminate\Support\Facades\Mail;

class RegisterController extends BaseController
{
    public function create()
    {
        return view('auth.register');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'password' => 'required|min:6|confirmed',
        ]);

        $existingMember = Member::where(
            'email',
            strtolower($request->email)
        )->first();

        if ($existingMember) {

            if ($existingMember->status == 'Nonaktif') {

                session([
                    'verify_member_id' => $existingMember->id
                ]);

                return redirect()
                    ->route('verify.email')
                    ->with(
                        'info',
                        'Email sudah terdaftar tetapi belum diverifikasi.'
                    );
            }

            return back()
                ->withErrors([
                    'email' => 'Email sudah digunakan.'
                ])
                ->withInput();
        }

        // Cari role anggota
        $role = Role::where('name', 'anggota')->first();

        if (!$role) {
            return back()
                ->withErrors([
                    'role' => 'Role anggota belum tersedia di database.'
                ])
                ->withInput();
        }

        // Generate kode anggota otomatis
        $lastMember = Member::orderBy('id', 'desc')->first();

        if (
            $lastMember &&
            preg_match('/MBR(\d+)/', $lastMember->member_code, $matches)
        ) {
            $nextNumber = (int)$matches[1] + 1;
        } else {
            $nextNumber = 1;
        }

        $memberCode = 'MBR' . str_pad(
            $nextNumber,
            4,
            '0',
            STR_PAD_LEFT
        );

        $member = new Member();

        $member->role_id = $role->id;
        $member->member_code = $memberCode;
        $member->name = $request->name;
        $member->email = strtolower($request->email);
        $member->password = Hash::make($request->password);
        $member->status = 'Nonaktif';

        $member->save();

        $otp = rand(100000, 999999);

        EmailOtp::create([

            'member_id' => $member->id,

            'otp' => $otp,

            'expired_at' => now()->addMinutes(5)

        ]);

        try {
            Mail::to($member->email)
                ->send(
                    new SendOtpMail($otp)
                );
        } catch (\Exception $e) {

            EmailOtp::where(
                'member_id',
                $member->id
            )->delete();

            $member->delete();

            return back()->with(
                'error',
                'Gagal mengirim email verifikasi.'
            );
        }

        session([
            'verify_member_id' => $member->id
        ]);

        return redirect()
            ->route('verify.email');
    }
}
