<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Author;
use Illuminate\Http\Request;

class AuthorController extends Controller
{
    public function index()
    {
        $authors = Author::withCount('books')->paginate(10);
        return response()->json($authors);
    }

    public function show($id)
    {
        $author = Author::with('books')->findOrFail($id);
        return response()->json($author);
    }

    public function update(Request $request, $id)
    {
        $author = Author::findOrFail($id);

        if ($request->user()->id !== $author->id) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $request->validate([
            'name' => 'required|unique:authors,name,' . $author->id,
        ]);

        $author->update($request->all());

        return response()->json($author);
    }
}
