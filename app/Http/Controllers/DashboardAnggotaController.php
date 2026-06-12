<?php

namespace App\Http\Controllers;

use App\Models\Loan;
use App\Models\Reservation;
use App\Models\ReturnBook;
use App\Models\Member;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Routing\Controller as BaseController;

class DashboardAnggotaController extends BaseController
{
    public function index(Request $request)
    {
        $memberId = session('member_id');

        if (!$memberId) {
            return redirect()->route('login');
        }

        $periode = $request->periode;

        $bulan = null;
        $tahun = null;

        if ($periode) {
            [$tahun, $bulan] = explode('-', $periode);
        }

        /*
        |--------------------------------------------------------------------------
        | STATISTIK GLOBAL
        |--------------------------------------------------------------------------
        */

        $activeLoans = Loan::where(
            'status',
            'Dipinjam'
        );

        $loanHistory = Loan::query();

        if ($periode) {

            $activeLoans
                ->whereYear('loan_date', $tahun)
                ->whereMonth('loan_date', $bulan);

            $loanHistory
                ->whereYear('loan_date', $tahun)
                ->whereMonth('loan_date', $bulan);
        }

        $activeLoans = $activeLoans->count();

        $loanHistory = $loanHistory->count();

        /*
        |--------------------------------------------------------------------------
        | TOTAL RESERVASI GLOBAL
        |--------------------------------------------------------------------------
        */

        $reservations = Reservation::query();

        if ($periode) {

            $reservations
                ->whereYear(
                    'reservation_date',
                    $tahun
                )
                ->whereMonth(
                    'reservation_date',
                    $bulan
                );
        }

        $reservations = $reservations->count();

        /*
        |--------------------------------------------------------------------------
        | DENDA SAYA (PERSONAL)
        |--------------------------------------------------------------------------
        */

        $fineQuery = ReturnBook::whereHas(
            'loan',
            function ($query) use ($memberId) {

                $query->where(
                    'member_id',
                    $memberId
                );
            }
        );

        if ($periode) {

            $fineQuery
                ->whereYear(
                    'return_date',
                    $tahun
                )
                ->whereMonth(
                    'return_date',
                    $bulan
                );
        }

        $fine = $fineQuery->sum('fine_amount');

        /*
        |--------------------------------------------------------------------------
        | STATISTIK
        |--------------------------------------------------------------------------
        */

        $stats = [

            'active_loans' => $activeLoans,

            'loan_history' => $loanHistory,

            'reservations' => $reservations,

            'fine' => $fine,

        ];

        /*
        |--------------------------------------------------------------------------
        | BUKU TERPOPULER (GLOBAL)
        |--------------------------------------------------------------------------
        */

        $popularBooks = Loan::select(
            'book_id',
            DB::raw('COUNT(*) as total')
        );

        if ($periode) {

            $popularBooks
                ->whereYear('loan_date', $tahun)
                ->whereMonth('loan_date', $bulan);
        }

        $popularBooks = $popularBooks
            ->with('book')
            ->groupBy('book_id')
            ->orderByDesc('total')
            ->take(5)
            ->get();

        /*
        |--------------------------------------------------------------------------
        | ANGGOTA TERAKTIF (GLOBAL)
        |--------------------------------------------------------------------------
        */

        $activeMembers = Loan::select(
            'member_id',
            DB::raw('COUNT(*) as total')
        );

        if ($periode) {

            $activeMembers
                ->whereYear('loan_date', $tahun)
                ->whereMonth('loan_date', $bulan);
        }

        $activeMembers = $activeMembers
            ->with('member')
            ->groupBy('member_id')
            ->orderByDesc('total')
            ->take(5)
            ->get();

        /*
        |--------------------------------------------------------------------------
        | ANGGOTA ONLINE
        |--------------------------------------------------------------------------
        */

        $onlineUsers = Member::where(
            'role_id',
            3
        )
            ->where(
                'updated_at',
                '>=',
                now()->subMinutes(10)
            )
            ->count();

        /*
        |--------------------------------------------------------------------------
        | GRAFIK PEMINJAMAN GLOBAL
        |--------------------------------------------------------------------------
        */

        $loanChart = [];

        if ($periode) {

            $days = cal_days_in_month(
                CAL_GREGORIAN,
                $bulan,
                $tahun
            );

            for ($d = 1; $d <= $days; $d++) {

                $loanChart[] = [

                    'bulan' => $d,

                    'jumlah' => Loan::whereDate(
                        'loan_date',
                        sprintf(
                            '%s-%s-%02d',
                            $tahun,
                            $bulan,
                            $d
                        )
                    )->count()

                ];
            }
        } else {

            for ($i = 5; $i >= 0; $i--) {

                $date = now()->subMonths($i);

                $loanChart[] = [

                    'bulan' => $date->format('M'),

                    'jumlah' => Loan::whereMonth(
                        'loan_date',
                        $date->month
                    )
                        ->whereYear(
                            'loan_date',
                            $date->year
                        )
                        ->count()

                ];
            }
        }

        return view(
            'anggota.dashboard.index',
            compact(
                'stats',
                'popularBooks',
                'activeMembers',
                'onlineUsers',
                'loanChart'
            )
        );
    }
}
