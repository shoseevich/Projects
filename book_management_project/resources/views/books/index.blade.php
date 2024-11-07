@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Книги</h1>
    <a href="{{ route('books.create') }}" class="btn btn-primary">Добавить книгу</a>
    <form action="{{ route('books.index') }}" method="GET" class="form-inline my-2 my-lg-0">
        <input class="form-control mr-sm-2" type="search" name="search" placeholder="Поиск по названию" aria-label="Search">
        <select class="form-control mr-sm-2" name="author_id">
            <option value="">Выберите автора</option>
            @foreach($authors as $author)
            <option value="{{ $author->id }}">{{ $author->name }}</option>
            @endforeach
        </select>
        <select class="form-control mr-sm-2" name="genre_id">
            <option value="">Выберите жанр</option>
            @foreach($genres as $genre)
            <option value="{{ $genre->id }}">{{ $genre->name }}</option>
            @endforeach
        </select>
        <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Поиск</button>
    </form>
    <table class="table">
        <thead>
            <tr>
                <th><a href="{{ route('books.index', ['sort' => request('sort') == 'asc' ? 'desc' : 'asc']) }}">Название</a></th>
                <th>Автор</th>
                <th>Жанры</th>
                <th>Дата добавления</th>
                <th>Действия</th>
            </tr>
        </thead>
        <tbody>
            @foreach($books as $book)
            <tr>
                <td>{{ $book->title }}</td>
                <td>{{ $book->author->name }}</td>
                <td>{{ $book->genres->pluck('name')->implode(', ') }}</td>
                <td>{{ $book->created_at->format('d.m.Y') }}</td>
                <td>
                    <a href="{{ route('books.edit', $book) }}" class="btn btn-sm btn-warning">Редактировать</a>
                    <form action="{{ route('books.destroy', $book) }}" method="POST" style="display:inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger">Удалить</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection