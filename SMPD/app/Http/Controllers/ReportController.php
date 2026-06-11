<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Session;
use App\Models\Loan;
use App\Models\ReturnBook;
use App\Models\Reservation;
use App\Models\Book;
use Carbon\Carbon;
use App\Models\Member;

class ReportController extends BaseController
{
    public function index()
    {
        $role = Session::get('role');

        // =========================
        // ADMIN REPORT
        // =========================

        if ($role == 'admin') {

            $systemReports = [

                [
                    'title' => 'Total Login',
                    'value' => 145,
                ],

                [
                    'title' => 'Server Latency',
                    'value' => '120ms',
                ],

                [
                    'title' => 'User Online',
                    'value' => 18,
                ],

            ];

            return view(
                'admin.reports.index',
                compact('systemReports')
            );
        }

        // =========================
        // PUSTAKAWAN REPORT
        // =========================

        $totalLoans = Loan::count();

        $totalReturns = ReturnBook::count();

        $lateReturns = ReturnBook::where(
            'late_days',
            '>',
            0
        )->count();

        $totalFines = ReturnBook::sum(
            'fine_amount'
        );

        $reports = [];

        for ($i = 11; $i >= 0; $i--) {

            $date = Carbon::now()->subMonths($i);

            $reports[] = [

                'month' =>
                $date->translatedFormat('F Y'),

                'total_loans' =>
                Loan::whereMonth(
                    'loan_date',
                    $date->month
                )
                ->whereYear(
                    'loan_date',
                    $date->year
                )
                ->count(),

                'total_returns' =>
                ReturnBook::whereMonth(
                    'return_date',
                    $date->month
                )
                ->whereYear(
                    'return_date',
                    $date->year
                )
                ->count(),

                'late_returns' =>
                ReturnBook::whereMonth(
                    'return_date',
                    $date->month
                )
                ->whereYear(
                    'return_date',
                    $date->year
                )
                ->where(
                    'late_days',
                    '>',
                    0
                )
                ->count(),

                'total_fines' =>
                ReturnBook::whereMonth(
                    'return_date',
                    $date->month
                )
                ->whereYear(
                    'return_date',
                    $date->year
                )
                ->sum(
                    'fine_amount'
                ),
            ];
        }

        return view(
            'pustakawan.reports.index',
            compact(
                'reports',
                'totalLoans',
                'totalReturns',
                'lateReturns',
                'totalFines'
            )
        );
    }

    public function exportPdf()
    {
        return redirect()
            ->route('reports.index')
            ->with(
                'success',
                'Laporan PDF berhasil diexport.'
            );
    }

    public function exportExcel()
    {
        return redirect()
            ->route('reports.index')
            ->with(
                'success',
                'Laporan Excel berhasil diexport.'
            );
    }
}
