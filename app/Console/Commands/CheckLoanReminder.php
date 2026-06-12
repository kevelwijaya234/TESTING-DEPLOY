<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Loan;
use App\Models\Notification;
use Carbon\Carbon;

class CheckLoanReminder extends Command
{
    protected $signature = 'loan:reminder';

    protected $description =
    'Cek jatuh tempo, keterlambatan dan denda';

    public function handle()
    {
        $tomorrow = Carbon::tomorrow();

        // H-1 JATUH TEMPO
        $dueTomorrow = Loan::with('book')
            ->whereDate('due_date', $tomorrow)
            ->where('status', 'Dipinjam')
            ->get();

        foreach ($dueTomorrow as $loan) {

            Notification::create([
                'member_id' => $loan->member_id,
                'title' => 'Pengingat Pengembalian Buku',
                'message' => 'Buku "' . $loan->book->title . '" akan jatuh tempo besok.',
                'type' => 'warning',
                'is_read' => false,
            ]);
        }

        // TERLAMBAT
        $lateLoans = Loan::with('book')
            ->whereDate('due_date', '<', now())
            ->where('status', 'Dipinjam')
            ->get();

        foreach ($lateLoans as $loan) {

            $loan->update([
                'status' => 'Terlambat'
            ]);

            Notification::create([
                'member_id' => $loan->member_id,
                'title' => 'Keterlambatan Pengembalian',
                'message' => 'Anda terlambat mengembalikan buku "' . $loan->book->title . '".',
                'type' => 'danger',
                'is_read' => false,
            ]);
        }

        $this->info('Reminder selesai dijalankan.');
    }
}
