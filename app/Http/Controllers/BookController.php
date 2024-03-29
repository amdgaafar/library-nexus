<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $books = Book::all();
        return view('books.index', ['books' => $books]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('books.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): \Illuminate\Http\RedirectResponse
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'publisher' => 'required|string|max:255',
            'isbn' => 'required|string|max:13',
            'edition' => 'required|integer',
            'year_published' => 'required|integer',
            'category' => 'required|string|max:255',
            'description' => 'required|string',
            'quantity' => 'required|integer',
        ]);

        Book::create($data);

        return redirect()->route('books.index')->with('success', 'Book created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Book $book)
    {
        return view('books.edit', compact('book'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Book $book)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
        ]);

        $book->update($data);

        return redirect()->route('books.index')->with('success', 'Book updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Book $book)
    {
        $book->delete();

        return redirect()->route('books.index')->with('success', 'Book deleted successfully!');
    }

    public function borrow(Request $request, Book $book)
    {
        $user = Auth::user();
        $borrowed_at = now();
        $days = $request->input('days');
        $return_by = now()->addDays($days);
        

        $book->borrowings()->create([
            'user_id' => $user->id,
            'borrowable_type' => Book::class,
            'borrowable_id' => $book->id,
            'borrowed_at' => $borrowed_at,
            'return_by' => $return_by,
        ]);

        return redirect()->route('books.index')->with('success', 'Book borrowed successfully!');
    }
}
