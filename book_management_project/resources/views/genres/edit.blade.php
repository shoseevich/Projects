@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Редактировать жанр</h1>
    <form action="{{ route('genres.update', $genre) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="name">Имя</label>
            <input type="text" name="name" id="name" class="form-control" value="{{ $genre->name }}" required>
        </div>
        <button type="submit" class="btn btn-primary">Сохранить</button>
    </form>
</div>
@endsection