<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseControllers;

class OpacController extends BaseControllers
{
    public function index(Request $request)
    {
        $books = Book::with('category')
            ->when($request->search, function ($query) use ($request) {
                $query->where('title', 'like', '%' . $request->search . '%')
                    ->orWhere('author', 'like', '%' . $request->search . '%')
                    ->orWhereHas('category', function ($categoryQuery) use ($request) {
                        $categoryQuery->where('name', 'like', '%' . $request->search . '%');
                    });
            })
            ->latest()
            ->paginate(12);

        return view('opac.index', compact('books'));
    }

    public function show(Book $book)
    {
        $isAvailable = $book->stock > 0;

        return view(
            'opac.detail',
            compact(
                'book',
                'isAvailable'
            )
        );
    }
}
