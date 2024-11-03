@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Edit Book</h1>
    <form action="{{ route('books.update', $book) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="title">Title</label>
            <input type="text" name="title" id="title" class="form-control" value="{{ $book->title }}" required>
        </div>
        <div class="form-group">
            <label for="author_id">Author</label>
            <select name="author_id" id="author_id" class="form-control" required>
                @foreach($authors as $author)
                    <option value="{{ $author->id }}" {{ $book->author_id == $author->id ? 'selected' : '' }}>{{ $author->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="type">Type</label>
            <select name="type" id="type" class="form-control" required>
                <option value="графическое издание" {{ $book->type == 'графическое издание' ? 'selected' : '' }}>Графическое издание</option>
                <option value="цифровое издание" {{ $book->type == 'цифровое издание' ? 'selected' : '' }}>Цифровое издание</option>
                <option value="печатное издание" {{ $book->type == 'печатное издание' ? 'selected' : '' }}>Печатное издание</option>
            </select>
        </div>
        <div class="form-group">
            <label for="genre_ids">Genres</label>
            <select name="genre_ids[]" id="genre_ids" class="form-control" multiple required>
                @foreach($genres as $genre)
                    <option value="{{ $genre->id }}" {{ in_array($genre->id, $book->genres->pluck('id')->toArray()) ? 'selected' : '' }}>{{ $genre->name }}</option>
                @endforeach
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Update</button>
    </form>
</div>
@endsection