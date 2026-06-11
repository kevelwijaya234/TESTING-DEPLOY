<?php

namespace App\Http\Controllers;

use App\Models\Loan;
use Illuminate\Support\Facades\DB;
use Illuminate\Routing\Controller as BaseController;

class StatisticController extends BaseController
{
    public function index()
    {
        $totalLoans = Loan::count();

        $monthlyLoans = Loan::whereMonth(
            'loan_date',
            now()->month
        )->count();

        $popularBooks = Loan::select(
            'book_id',
            DB::raw('COUNT(*) as total')
        )
            ->with('book')
            ->groupBy('book_id')
            ->orderByDesc('total')
            ->take(5)
            ->get();

        $activeMembers = Loan::select(
            'member_id',
            DB::raw('COUNT(*) as total')
        )
            ->with('member')
            ->groupBy('member_id')
            ->orderByDesc('total')
            ->take(5)
            ->get();

        $topBook =
            $popularBooks->first();

        $topMember =
            $activeMembers->first();

        return view(
            'admin.statistics.index',
            compact(
                'totalLoans',
                'monthlyLoans',
                'popularBooks',
                'activeMembers',
                'topBook',
                'topMember'
            )
        );
    }
}
