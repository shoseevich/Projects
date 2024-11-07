@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Жанры</h1>
    <a href="{{ route('genres.create') }}" class="btn btn-primary">Добавить жанр</a>
    <table class="table">
        <thead>
            <tr>
                <th>Имя</th>
                <th>Действия</th>
            </tr>
        </thead>
        <tbody>
            @foreach($genres as $genre)
            <tr>
                <td>{{ $genre->name }}</td>
                <td>
                    <a href="{{ route('genres.edit', $genre) }}" class="btn btn-sm btn-warning">Редактировать</a>
                    <form action="{{ route('genres.destroy', $genre) }}" method="POST" style="display:inline">
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