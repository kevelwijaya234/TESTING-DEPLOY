<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Member;
use App\Models\Reservation;
use Illuminate\Http\Request;
use App\Models\Loan;
use Illuminate\Routing\Controller as BaseController;
use App\Models\Notification;

class ReservationController extends BaseController
{
    //Pustakwan
    public function index()
    {
        $reservations = Reservation::with([
            'member',
            'book',
            'digitalBook'
        ])
            ->latest()
            ->paginate(10);

        $totalReservations = Reservation::count();

        $waitingReservations = Reservation::where(
            'status',
            'Menunggu'
        )->count();

        $approvedReservations = Reservation::where(
            'status',
            'Disetujui'
        )->count();

        return view(
            'pustakawan.reservations.pustakawan',
            compact(
                'reservations',
                'totalReservations',
                'waitingReservations',
                'approvedReservations'
            )
        );
    }

    //anggota
    public function anggota()
    {
        $memberId = session('member_id');

        $member = Member::findOrFail($memberId);

        $reservations = Reservation::with([
            'member',
            'book',
            'digitalBook'
        ])
            ->where('member_id', $memberId)
            ->latest()
            ->paginate(10);

        $totalReservations = Reservation::where(
            'member_id',
            $memberId
        )->count();

        $waitingReservations = Reservation::where(
            'member_id',
            $memberId
        )
            ->where('status', 'Menunggu')
            ->count();

        $approvedReservations = Reservation::where(
            'member_id',
            $memberId
        )
            ->where('status', 'Disetujui')
            ->count();

        return view(
            'anggota.reservations.anggota',
            compact(
                'member',
                'reservations',
                'totalReservations',
                'waitingReservations',
                'approvedReservations'
            )
        );
    }

    // ==========================
    // SIMPAN RESERVASI
    // ==========================

    public function store(Request $request)
    {
        $request->validate([
            'reservation_date' => 'required|date',
            'book_type' => 'required|in:fisik,digital',
        ]);

        $member = Member::findOrFail(
            session('member_id')
        );

        // ======================
        // RESERVASI EBOOK
        // ======================

        if ($request->book_type == 'digital') {

            $existingReservation = Reservation::where(
                'member_id',
                $member->id
            )
                ->where(
                    'digital_book_id',
                    $request->digital_book_id
                )
                ->where(
                    'status',
                    'Menunggu'
                )
                ->exists();

            if ($existingReservation) {

                return back()->withErrors([
                    'ebook' => 'E-book ini sudah Anda reservasi.'
                ]);
            }

            Reservation::create([

                'reservation_code' =>
                'RSV' . now()->format('YmdHis'),

                'member_id' =>
                $member->id,

                'digital_book_id' =>
                $request->digital_book_id,

                'book_type' =>
                'digital',

                'reservation_date' =>
                now(),

                'status' =>
                'Menunggu',
            ]);

            return redirect()
                ->route('reservations.anggota')
                ->with(
                    'success',
                    'Reservasi e-book berhasil dibuat.'
                );
        }

        // ======================
        // RESERVASI BUKU FISIK
        // ======================

        $book = Book::where(
            'kode_buku',
            $request->kode_buku
        )->firstOrFail();

        if ($book->stock > 0) {

            return back()->withErrors([
                'kode_buku' =>
                'Buku masih tersedia dan tidak perlu direservasi.'
            ]);
        }

        $existingReservation = Reservation::where(
            'member_id',
            $member->id
        )
            ->where(
                'book_id',
                $book->id
            )
            ->where(
                'status',
                'Menunggu'
            )
            ->exists();

        if ($existingReservation) {

            return back()->withErrors([
                'kode_buku' =>
                'Buku ini sudah Anda reservasi.'
            ]);
        }

        Reservation::create([

            'reservation_code' =>
            'RSV' . now()->format('YmdHis'),

            'member_id' =>
            $member->id,

            'book_id' =>
            $book->id,

            'book_type' =>
            'fisik',

            'reservation_date' =>
            $request->reservation_date,

            'status' =>
            'Menunggu',
        ]);

        if ($request->from == 'anggota') {

            return redirect()
                ->route('reservations.anggota')
                ->with(
                    'success',
                    'Reservasi buku berhasil dibuat.'
                );
        }

        return redirect()
            ->route('reservations.pustakawan')
            ->with(
                'success',
                'Reservasi buku berhasil dibuat.'
            );
    }

    // ==========================
    // APPROVE
    // ==========================

    public function approve(Reservation $reservation)
    {
        if ($reservation->book_type == 'digital') {

            $reservation->update([
                'status' => 'Disetujui',
                'access_until' => now()->addDays(7),
            ]);
        } else {

            $reservation->update([
                'status' => 'Disetujui',
            ]);
        }

        return redirect()
            ->route('reservations.pustakawan')
            ->with(
                'success',
                'Reservasi berhasil disetujui.'
            );
    }

    // ==========================
    // CANCEL
    // ==========================

    public function cancel(Reservation $reservation)
    {
        $reservation->update([
            'status' => 'Dibatalkan'
        ]);

        Notification::create([
            'member_id' => $reservation->member_id,
            'title' => 'Reservasi Ditolak',
            'message' => 'Reservasi buku Anda ditolak oleh pustakawan.',
            'type' => 'danger',
            'is_read' => false,
        ]);

        return redirect()
            ->route('reservations.pustakawan')
            ->with(
                'success',
                'Reservasi berhasil ditolak.'
            );
    }
}
