<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Log;
use Illuminate\Http\Request;

class BookController extends Controller
{
    public function index()
    {
        $books = Book::with('author')->paginate(10);
        return response()->json($books);
    }

    public function show($id)
    {
        $book = Book::with('author', 'genres')->findOrFail($id);
        return response()->json($book);
    }

    public function update(Request $request, $id)
    {
        $book = Book::findOrFail($id);

        if ($request->user()->id !== $book->author_id) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $request->validate([
            'title' => 'required|unique:books,title,' . $book->id,
            'type' => 'required|in:графическое издание,цифровое издание,печатное издание',
        ]);

        $book->update($request->all());

        Log::create([
            'action' => 'Книга обновлена',
            'book_id' => $book->id,
        ]);

        return response()->json($book);
    }

    public function destroy(Request $request, $id)
    {
        $book = Book::findOrFail($id);

        if ($request->user()->id !== $book->author_id) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $book->delete();

        Log::create([
            'action' => 'Книга удалена',
            'book_id' => $book->id,
        ]);

        return response()->json(['message' => 'Книга успешно удалена']);
    }
}