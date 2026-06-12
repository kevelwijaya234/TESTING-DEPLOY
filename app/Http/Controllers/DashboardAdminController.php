<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Loan;
use App\Models\Member;
use App\Models\Reservation;
use Carbon\Carbon;
use Illuminate\Routing\Controller as BaseController;

class DashboardAdminController extends BaseController
{
    public function index()
    {
        // Statistik Utama
        $totalBooks = Book::count();

        $totalMembers = Member::where('role_id', 3)->count();

        $totalLibrarians = Member::where('role_id', 2)->count();

        $todayLoans = Loan::whereDate(
            'created_at',
            Carbon::today()
        )->count();

        $activeUsers = Member::where(
            'status',
            'Aktif'
        )->count();

        // Progress Bar
        $totalLoans = Loan::count();

        $borrowPercent = $totalBooks > 0
            ? round(($totalLoans / $totalBooks) * 100)
            : 0;

        $borrowPercent = min($borrowPercent, 100);

        $reservationPercent = $totalMembers > 0
            ? round(
                (Reservation::count() / $totalMembers) * 100
            )
            : 0;

        $reservationPercent = min(
            $reservationPercent,
            100
        );

        // Aktivitas Terbaru
        $activities = Loan::with([
            'member',
            'book'
        ])
            ->latest()
            ->take(10)
            ->get();

        // Grafik 7 Hari Terakhir
        $chartLabels = [];
        $chartData = [];

        for ($i = 6; $i >= 0; $i--) {

            $date = Carbon::now()->subDays($i);

            $chartLabels[] = $date->format('d M');

            $chartData[] = Loan::whereDate(
                'created_at',
                $date->toDateString()
            )->count();
        }

        return view(
            'admin.dashboard.index',
            compact(
                'totalBooks',
                'totalMembers',
                'totalLibrarians',
                'todayLoans',
                'activeUsers',
                'borrowPercent',
                'reservationPercent',
                'activities',
                'chartLabels',
                'chartData'
            )
        );
    }
}
