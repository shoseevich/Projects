<?php

namespace App\Http\Controllers\Admin;

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Author;
use App\Models\Genre;
use App\Models\Log;
use Illuminate\Http\Request;

class BookController extends Controller
{
    public function index(Request $request)
    {
        $query = Book::with('author', 'genres');

        if ($request->has('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        if ($request->has('author_id')) {
            $query->where('author_id', $request->author_id);
        }

        if ($request->has('genre_id')) {
            $query->whereHas('genres', function ($q) use ($request) {
                $q->where('genre_id', $request->genre_id);
            });
        }

        if ($request->has('sort')) {
            $query->orderBy('title', $request->sort);
        }

        $books = $query->get();
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
            'genres' => 'required|array',
            'genres.*' => 'exists:genres,id',
        ]);

        $book = Book::create($request->all());
        $book->genres()->attach($request->genres);

        Log::create([
            'action' => 'Книга создана',
            'book_id' => $book->id,
        ]);

        return redirect()->route('books.index')->with('success', 'Книга успешно создана.');
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
            'genres' => 'required|array',
            'genres.*' => 'exists:genres,id',
        ]);

        $book->update($request->all());
        $book->genres()->sync($request->genres);

        Log::create([
            'action' => 'Книга обновлена',
            'book_id' => $book->id,
        ]);

        return redirect()->route('books.index')->with('success', 'Книга успешно обновлена.');
    }

    public function destroy(Book $book)
    {
        $book->delete();

        Log::create([
            'action' => 'Книга удалена',
            'book_id' => $book->id,
        ]);

        return redirect()->route('books.index')->with('success', 'Книга успешно удалена.');
    }
}
