<?php

namespace App\Http\Controllers;

use App\Models\Member;
use App\Models\EmailOtp;
use App\Mail\SendOtpMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Routing\Controller as BaseController;
use App\Mail\VerifyOtpMail;

class EmailVerificationController extends BaseController
{
    /*
    |--------------------------------------------------------------------------
    | Tampilkan Form OTP
    |--------------------------------------------------------------------------
    */

    public function showForm()
    {
        if (!session('verify_member_id')) {

            return redirect()
                ->route('register');
        }

        return view('auth.verify-email');
    }

    /*
    |--------------------------------------------------------------------------
    | Verifikasi OTP
    |--------------------------------------------------------------------------
    */

    public function verify(Request $request)
    {
        $request->validate([
            'otp' => 'required'
        ]);

        $memberId = session('verify_member_id');

        $member = Member::find($memberId);

        if (!$member) {

            return redirect()
                ->route('register');
        }

        $otpData = EmailOtp::where(
            'member_id',
            $member->id
        )
            ->where(
                'otp',
                $request->otp
            )
            ->latest()
            ->first();

        if (!$otpData) {

            return back()
                ->with(
                    'error',
                    'Kode OTP tidak valid.'
                );
        }

        if (now()->gt($otpData->expired_at)) {

            return back()
                ->with(
                    'error',
                    'Kode OTP sudah kadaluarsa.'
                );
        }

        $member->update([

            'status' => 'Aktif',

            'email_verified_at' => now()

        ]);

        EmailOtp::where(
            'member_id',
            $member->id
        )->delete();

        session()->forget(
            'verify_member_id'
        );

        return redirect()
            ->route('login')
            ->with(
                'success',
                'Email berhasil diverifikasi. Silakan login.'
            );
    }

    /*
    |--------------------------------------------------------------------------
    | Kirim Ulang OTP
    |--------------------------------------------------------------------------
    */

    public function resendOtp()
    {
        $memberId = session('verify_member_id');

        $member = Member::find($memberId);

        if (!$member) {

            return redirect()
                ->route('register');
        }

        EmailOtp::where(
            'member_id',
            $member->id
        )->delete();

        $otp = rand(
            100000,
            999999
        );

        EmailOtp::create([

            'member_id' => $member->id,

            'otp' => $otp,

            'expired_at' => now()->addMinutes(5)

        ]);

        Mail::to(
            $member->email
        )->send(
            new SendOtpMail($otp)
        );

        return back()
            ->with(
                'success',
                'OTP baru berhasil dikirim.'
            );
    }
}
