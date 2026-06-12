<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller as BaseController;

use App\Models\Book;
use App\Models\Loan;
use App\Models\Member;
use App\Models\Reservation;
use App\Models\ReturnBook;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardPustakawanController extends BaseController
{
    public function index(Request $request)
    {
        $periode = $request->periode;

        $bulan = null;
        $tahun = null;

        if ($periode) {
            [$tahun, $bulan] = explode('-', $periode);
        }

        $labels = [];
        $data = [];

        /*
|--------------------------------------------------------------------------
| Grafik Peminjaman
|--------------------------------------------------------------------------
*/

        if ($periode) {

            $days = cal_days_in_month(
                CAL_GREGORIAN,
                $bulan,
                $tahun
            );

            for ($d = 1; $d <= $days; $d++) {

                $labels[] = $d;

                $data[] = Loan::whereDate(
                    'loan_date',
                    sprintf(
                        '%s-%s-%02d',
                        $tahun,
                        $bulan,
                        $d
                    )
                )->count();
            }
        } else {

            for ($i = 5; $i >= 0; $i--) {

                $date = now()->subMonths($i);

                $labels[] = $date->format('M');

                $data[] = Loan::whereMonth(
                    'loan_date',
                    $date->month
                )
                    ->whereYear(
                        'loan_date',
                        $date->year
                    )
                    ->count();
            }
        }

        /*
        |--------------------------------------------------------------------------
        | Statistik Dashboard
        |--------------------------------------------------------------------------
        */

        // Total seluruh peminjaman
        $loanQuery = Loan::query();

        $returnQuery = ReturnBook::query();

        $reservationQuery = Reservation::where(
            'status',
            'Menunggu'
        );

        $lateQuery = ReturnBook::where(
            'late_days',
            '>',
            0
        );

        if ($periode) {

            $loanQuery
                ->whereYear('loan_date', $tahun)
                ->whereMonth('loan_date', $bulan);

            $returnQuery
                ->whereYear('return_date', $tahun)
                ->whereMonth('return_date', $bulan);

            $reservationQuery
                ->whereYear('reservation_date', $tahun)
                ->whereMonth('reservation_date', $bulan);

            $lateQuery
                ->whereYear('return_date', $tahun)
                ->whereMonth('return_date', $bulan);
        }

        $totalLoans = $loanQuery->count();

        $totalReturns = $returnQuery->count();

        $pendingReservations = $reservationQuery->count();

        $lateLoans = $lateQuery->count();
        /*
        |--------------------------------------------------------------------------
        | Ringkasan Sistem
        |--------------------------------------------------------------------------
        */

        $totalBooks = Book::count();

        $totalMembers = Member::count();

        $borrowedBooksQuery = Loan::where(
            'status',
            'Dipinjam'
        );

        if ($periode) {

            $borrowedBooksQuery
                ->whereYear('loan_date', $tahun)
                ->whereMonth('loan_date', $bulan);
        }

        $borrowedBooks = $borrowedBooksQuery->count();

        $availableBooks =
            $totalBooks - $borrowedBooks;

        /*
        |--------------------------------------------------------------------------
        | Reservasi Terbaru
        |--------------------------------------------------------------------------
        */

        $reservations = Reservation::with([
            'member',
            'book',
            'digitalBook'
        ]);

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

        $reservations = $reservations
            ->latest()
            ->take(5)
            ->get();

        /*
        |--------------------------------------------------------------------------
        | Buku Terpopuler
        |--------------------------------------------------------------------------
        */

        $popularLoanQuery = Loan::with('book');

        if ($periode) {

            $popularLoanQuery
                ->whereYear('loan_date', $tahun)
                ->whereMonth('loan_date', $bulan);
        }

        $popularBooks = $popularLoanQuery
            ->get()
            ->groupBy('book_id')
            ->map(function ($item) {

                return [

                    'title' =>
                    optional(
                        $item->first()->book
                    )->title ?? '-',

                    'total' =>
                    $item->count()
                ];
            })
            ->sortByDesc('total')
            ->take(5);

        /*
        |--------------------------------------------------------------------------
        | Return View
        |--------------------------------------------------------------------------
        */

        return view(
            'pustakawan.dashboard.index',
            compact(
                'periode',
                'labels',
                'data',

                'totalLoans',
                'totalReturns',
                'pendingReservations',
                'lateLoans',

                'totalBooks',
                'totalMembers',

                'borrowedBooks',
                'availableBooks',

                'reservations',
                'popularBooks'
            )
        );
    }
}
