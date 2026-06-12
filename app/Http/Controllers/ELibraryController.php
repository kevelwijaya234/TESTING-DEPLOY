<?php

namespace App\Http\Controllers;

use App\Models\DigitalBook;
use App\Models\Reservation;
use Illuminate\Routing\Controller as BaseControllers;

class ELibraryController extends BaseControllers
{
    public function index()
    {
        $digitalBooks = DigitalBook::with('category')->latest()->get();
        return view('e-library.index', compact('digitalBooks'));
    }

    public function read($id)
    {
        $digitalBook = DigitalBook::findOrFail($id);

        $memberId = session('member_id');

        $reservation = Reservation::where(
            'digital_book_id',
            $digitalBook->id
        )
            ->where(
                'member_id',
                $memberId
            )
            ->where(
                'status',
                'Disetujui'
            )
            ->where(
                'access_until',
                '>=',
                now()
            )
            ->first();

        return view(
            'e-library.read',
            compact(
                'digitalBook',
                'reservation'
            )
        );
    }

    public function show($id)
    {
        $digitalBook = DigitalBook::with(
            'category'
        )->findOrFail($id);

        return view(
            'e-library.show',
            compact('digitalBook')
        );
    }
}
