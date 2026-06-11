<?php

namespace App\Http\Controllers;

use App\Models\Loan;
use App\Models\ReturnBook;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Routing\Controller as BaseController;
use App\Models\Reservation;
use App\Models\Notification;

class ReturnController extends BaseController
{
    public function index()
    {
        $returns = ReturnBook::with([
            'loan.member',
            'loan.book'
        ])
            ->latest()
            ->paginate(10);

        // Total Pengembalian
        $todayReturns = ReturnBook::count();

        // Total pengembalian terlambat
        $lateReturns = ReturnBook::where(
            'late_days',
            '>',
            0
        )->count();

        // Total denda terkumpul
        $totalFine = ReturnBook::sum(
            'fine_amount'
        );

        return view(
            'pustakawan.returns.index',
            compact(
                'returns',
                'todayReturns',
                'lateReturns',
                'totalFine'
            )
        );
    }


    public function process(Request $request)
    {

        $request->validate(
            [
                'loan_code'    => 'required',
                'kode_buku' => 'required',
                'return_date'  => 'required|date',
            ],
            [
                'loan_code.required' =>
                'Kode peminjaman wajib diisi.',

                'kode_buku.required' =>
                'Kode buku wajib diisi.',

                'return_date.required' =>
                'Tanggal pengembalian wajib diisi.',
            ]
        );

        $loan = Loan::with(['book', 'member'])
            ->where('loan_code', $request->loan_code)
            ->first();

        if (!$loan) {
            return redirect()
                ->back()
                ->with('error', 'Kode peminjaman tidak ditemukan.');
        }

        if ($loan->book->kode_buku != $request->kode_buku) {
            return redirect()
                ->back()
                ->with('error', 'Kode buku tidak sesuai.');
        }

        if ($loan->status == 'Dikembalikan') {
            return redirect()
                ->back()
                ->with('error', 'Buku sudah dikembalikan.');
        }

        $returnDate = strtotime($request->return_date);
        $dueDate = strtotime($loan->due_date);

        $lateDays = 0;

        if ($returnDate > $dueDate) {

            $lateDays = floor(
                ($returnDate - $dueDate) / 86400
            );
        }

        $fineAmount = $lateDays * 5000;

        DB::transaction(function () use (
            $loan,
            $request,
            $lateDays,
            $fineAmount
        ) {

            if (ReturnBook::where(
                'loan_id',
                $loan->id
            )->exists()) {

                return redirect()
                    ->back()
                    ->with(
                        'error',
                        'Data pengembalian sudah pernah dibuat.'
                    );
            }

            $loan->book->increment('stock');

            $reservation = Reservation::where(
                'book_id',
                $loan->book_id
            )
                ->where(
                    'status',
                    'Menunggu'
                )
                ->oldest()
                ->first();

            if ($reservation) {

                $reservation->update([
                    'status' => 'Disetujui'
                ]);

                Notification::create([
                    'member_id' => $reservation->member_id,
                    'title' => 'Reservasi Disetujui',
                    'message' => 'Buku "' . $loan->book->title . '" sudah tersedia dan reservasi Anda telah disetujui.',
                    'type' => 'success',
                    'is_read' => false,
                ]);
            }

            Notification::create([
                'member_id' => $loan->member_id,
                'title' => 'Pengembalian Berhasil',
                'message' => 'Buku "' . $loan->book->title . '" telah dikembalikan.',
                'type' => 'success',
                'is_read' => false,
            ]);

            if ($fineAmount > 0) {

                Notification::create([
                    'member_id' => $loan->member_id,
                    'title' => 'Denda Keterlambatan',
                    'message' => 'Anda memiliki denda Rp ' . number_format($fineAmount),
                    'type' => 'warning',
                    'is_read' => false,
                ]);
            }

            ReturnBook::create([
                'return_code' => 'RT' . now()->format('YmdHis'),
                'loan_id' => $loan->id,
                'return_date' => $request->return_date,
                'late_days' => $lateDays,
                'fine_amount' => $fineAmount,
            ]);

            $loan->update([
                'status' => 'Dikembalikan'
            ]);
        });

        return redirect()
            ->route('returns.index')
            ->with(
                'success',
                'Pengembalian berhasil ditambahkan.'
            );
    }
}
