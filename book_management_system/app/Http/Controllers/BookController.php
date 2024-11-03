<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Author;
use App\Models\Genre;
use App\Models\Log;
use Illuminate\Http\Request;

class BookController extends Controller
{
    public function index(Request $request)
    {
        $books = Book::with('author', 'genres');

        if ($request->has('search')) {
            $books->where('title', 'like', '%' . $request->search . '%');
        }

        if ($request->has('author_id')) {
            $books->where('author_id', $request->author_id);
        }

        if ($request->has('genre_id')) {
            $books->whereHas('genres', function ($query) use ($request) {
                $query->where('genre_id', $request->genre_id);
            });
        }

        $books = $books->orderBy('title')->get();

        $authors = Author::all();
        $genres = Genre::all();

        return view('books.index', compact('books', 'authors', 'genres'));
    }

    public function create()
    {
        $authors = Author::all();
        $genres = Genre::all();
        return view('books.create', compact('authors', 'genres'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|unique:books',
            'author_id' => 'required|exists:authors,id',
            'type' => 'required|in:графическое издание,цифровое издание,печатное издание',
            'genre_ids' => 'required|array',
            'genre_ids.*' => 'exists:genres,id',
        ]);

        $book = Book::create($request->except('genre_ids'));
        $book->genres()->sync($request->genre_ids);

        Log::create([
            'action' => 'Book created',
            'book_id' => $book->id,
        ]);

        return redirect()->route('books.index')->with('success', 'Book created successfully.');
    }

    public function edit(Book $book)
    {
        $authors = Author::all();
        $genres = Genre::all();
        return view('books.edit', compact('book', 'authors', 'genres'));
    }

    public function update(Request $request, Book $book)
    {
        $request->validate([
            'title' => 'required|unique:books,title,' . $book->id,
            'author_id' => 'required|exists:authors,id',
            'type' => 'required|in:графическое издание,цифровое издание,печатное издание',
            'genre_ids' => 'required|array',
            'genre_ids.*' => 'exists:genres,id',
        ]);

        $book->update($request->except('genre_ids'));
        $book->genres()->sync($request->genre_ids);

        Log::create([
            'action' => 'Book updated',
            'book_id' => $book->id,
        ]);

        return redirect()->route('books.index')->with('success', 'Book updated successfully.');
    }

    public function destroy(Book $book)
    {
        $book->delete();

        Log::create([
            'action' => 'Book deleted',
            'book_id' => $book->id,
        ]);

        return redirect()->route('books.index')->with('success', 'Book deleted successfully.');
    }
}
