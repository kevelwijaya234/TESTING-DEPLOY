<?php

namespace App\Http\Controllers;

use App\Models\Member;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Routing\Controller as BaseController;

class MemberController extends BaseController
{
    /*
    |--------------------------------------------------------------------------
    | INDEX
    |--------------------------------------------------------------------------
    */
    public function index(Request $request)
    {
        $search = $request->search;

        $members = Member::query()

            ->when($search, function ($query) use ($search) {

                $query->where(
                    'member_code',
                    'like',
                    "%{$search}%"
                )

                    ->orWhere(
                        'name',
                        'like',
                        "%{$search}%"
                    )

                    ->orWhere(
                        'email',
                        'like',
                        "%{$search}%"
                    )

                    ->orWhere(
                        'phone',
                        'like',
                        "%{$search}%"
                    );
            })

            ->latest()

            ->paginate(10)

            ->withQueryString();

        return view(
            'admin.members.index',
            compact('members')
        );
    }

    /*
    |--------------------------------------------------------------------------
    | CREATE
    |--------------------------------------------------------------------------
    */
    public function create()
    {
        return view('admin.members.create');
    }

    /*
    |--------------------------------------------------------------------------
    | STORE
    |--------------------------------------------------------------------------
    */
    public function store(Request $request)
    {
        $request->validate([

            'name' =>
            'required|string|max:255',

            'email' =>
            'required|email|unique:members,email',

            'phone' =>
            'required|string|max:20',

            'address' =>
            'required|string',

            'status' =>
            'required|in:Aktif,Nonaktif',

        ]);

        // Generate Kode Anggota Otomatis

        $lastMember = Member::latest('id')->first();

        if ($lastMember) {

            $number = (int) substr(
                $lastMember->member_code,
                3
            );

            $memberCode = 'MBR' . str_pad(
                $number + 1,
                4,
                '0',
                STR_PAD_LEFT
            );
        } else {

            $memberCode = 'MBR0001';
        }

        Member::create([

            'role_id' => 3,

            'member_code' => $memberCode,

            'name' => $request->name,

            'email' => $request->email,

            'password' => Hash::make('123456'),

            'phone' => $request->phone,

            'address' => $request->address,

            'status' => $request->status,

        ]);

        return redirect()

            ->route('members.index')

            ->with(
                'success',
                'Data anggota berhasil ditambahkan.'
            );
    }

    /*
    |--------------------------------------------------------------------------
    | SHOW
    |--------------------------------------------------------------------------
    */
    public function show(Member $member)
    {
        return view(
            'admin.members.show',
            compact('member')
        );
    }

    /*
    |--------------------------------------------------------------------------
    | EDIT
    |--------------------------------------------------------------------------
    */
    public function edit(Member $member)
    {
        return view(
            'admin.members.edit',
            compact('member')
        );
    }

    /*
    |--------------------------------------------------------------------------
    | UPDATE
    |--------------------------------------------------------------------------
    */
    public function update(
        Request $request,
        Member $member
    ) {
        $request->validate([

            'name' =>
            'required|string|max:255',

            'email' =>
            'required|email|unique:members,email,' . $member->id,

            'phone' =>
            'required|string|max:20',

            'address' =>
            'required|string',

            'status' =>
            'required|in:Aktif,Nonaktif',

        ]);

        $member->update([

            'name' => $request->name,

            'email' => $request->email,

            'phone' => $request->phone,

            'address' => $request->address,

            'status' => $request->status,

        ]);

        return redirect()

            ->route('members.index')

            ->with(
                'success',
                'Data anggota berhasil diperbarui.'
            );
    }

    /*
    |--------------------------------------------------------------------------
    | DELETE
    |--------------------------------------------------------------------------
    */
    public function destroy(Member $member)
    {
        $member->delete();

        return redirect()

            ->route('members.index')

            ->with(
                'success',
                'Data anggota berhasil dihapus.'
            );
    }

    /*
    |--------------------------------------------------------------------------
    | MEMBER CARD
    |--------------------------------------------------------------------------
    */
    public function card($id)
    {
        $member = Member::findOrFail($id);

        return view(
            'admin.members.card',
            compact('member')
        );
    }
}
