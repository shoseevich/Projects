@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Logs</h1>
    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Action</th>
                <th>Book ID</th>
                <th>Created At</th>
            </tr>
        </thead>
        <tbody>
            @foreach($logs as $log)
            <tr>
                <td>{{ $log->id }}</td>
                <td>{{ $log->action }}</td>
                <td>{{ $log->book_id }}</td>
                <td>{{ $log->created_at }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection