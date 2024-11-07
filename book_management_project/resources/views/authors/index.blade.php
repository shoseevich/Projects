@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Авторы</h1>
    <a href="{{ route('authors.create') }}" class="btn btn-primary">Добавить автора</a>
    <table class="table">
        <thead>
            <tr>
                <th>Имя</th>
                <th>Количество книг</th>
                <th>Действия</th>
            </tr>
        </thead>
        <tbody>
            @foreach($authors as $author)
            <tr>
                <td>{{ $author->name }}</td>
                <td>{{ $author->books_count }}</td>
                <td>
                    <a href="{{ route('authors.edit', $author) }}" class="btn btn-sm btn-warning">Редактировать</a>
                    <form action="{{ route('authors.destroy', $author) }}" method="POST" style="display:inline">
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