@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Genres</h1>
    <a href="{{ route('genres.create') }}" class="btn btn-primary">Create Genre</a>
    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($genres as $genre)
            <tr>
                <td>{{ $genre->id }}</td>
                <td>{{ $genre->name }}</td>
                <td>
                    <a href="{{ route('genres.edit', $genre) }}" class="btn btn-sm btn-warning">Edit</a>
                    <form action="{{ route('genres.destroy', $genre) }}" method="POST" style="display:inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection