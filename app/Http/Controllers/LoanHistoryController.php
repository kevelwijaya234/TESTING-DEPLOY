<?php

namespace App\Http\Controllers;

use App\Models\Loan;
use Illuminate\Routing\Controller as BaseController;

class LoanHistoryController extends BaseController
{
    // Pustakawan - semua histori
    public function index()
    {
        $loans = Loan::with([
            'member',
            'book'
        ])
            ->latest()
            ->paginate(10);

        return view(
            'loanhistory.index',
            compact('loans')
        );
    }

    // Anggota - hanya histori miliknya
    public function anggota()
    {
        $loans = Loan::with([
            'book'
        ])
            ->where(
                'member_id',
                session('member_id')
            )
            ->latest()
            ->paginate(10);

        return view(
            'anggota.loanhistory.index',
            compact('loans')
        );
    }
}
