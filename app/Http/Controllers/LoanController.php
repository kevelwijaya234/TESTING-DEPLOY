<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Loan;
use App\Models\Member;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Routing\Controller as BaseControllers;
use App\Models\Reservation;
use App\Models\Notification;

class LoanController extends BaseControllers
{
    public function index()
    {
        $loans = Loan::latest()->paginate(10);

        return view(
            'pustakawan.loans.index',
            compact('loans')
        );
    }

    public function create()
    {
        return view('pustakawan.loans.create');
    }
    public function store(Request $request)
    {
        $request->validate([
            'member_code' => 'required',
            'kode_buku'   => 'required',
            'loan_date'   => 'required|date',
        ]);

        $member = Member::where('member_code', $request->member_code)
            ->where('status', 'Aktif')
            ->first();

        if (!$member) {
            return back()->with('error', 'Anggota tidak ditemukan atau status tidak aktif.');
        }

        $book = Book::where('kode_buku', $request->kode_buku)->first();

        if (!$book) {
            return back()->with('error', 'Buku dengan kode tersebut tidak ditemukan.');
        }

        if ($book->stock <= 0) {
            return back()->with('error', 'Stok buku habis.');
        }

        $reservation = Reservation::where(
            'member_id',
            $member->id
        )
            ->where(
                'book_id',
                $book->id
            )
            ->where(
                'status',
                'Disetujui'
            )
            ->first();

        DB::transaction(function () use (
            $request,
            $member,
            $book,
            $reservation
        ) {

            Loan::create([
                'loan_code' => 'LN' . now()->format('YmdHis'),
                'member_id' => $member->id,
                'book_id'   => $book->id,
                'loan_date' => $request->loan_date,
                'due_date' => date(
                    'Y-m-d',
                    strtotime($request->loan_date . ' +5 days')
                ),
                'status'    => 'Dipinjam',
            ]);

            $book->decrement('stock');

            if ($reservation) {

                $reservation->update([
                    'status' => 'Selesai'
                ]);
            }
        });

        Notification::create([
            'member_id' => $member->id,
            'title' => 'Peminjaman Berhasil',
            'message' => 'Buku "' . $book->title . '" berhasil dipinjam sampai tanggal '
                . date(
                    'd-m-Y',
                    strtotime($request->loan_date . ' +5 days')
                ),
            'type' => 'success',
            'is_read' => false,
        ]);

        return redirect()
            ->route('loans.index')
            ->with(
                'success',
                'Peminjaman buku berhasil disimpan dan stok buku otomatis berkurang.'
            );
    }
}
