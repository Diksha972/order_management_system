@extends('layout')

@section('content')
<h2>Manage Users</h2>

@if(session('success'))
    <p style="color: green;">{{ session('success') }}</p>
@endif

<table border="1" cellpadding="8">
    <thead>
        <tr>
            <th>Name</th><th>Email</th><th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach($users as $user)
        <tr>
            <td>{{ $user->name }}</td>
            <td>{{ $user->email }}</td>
            <td>
                <form action="{{ route('admin.users.delete', $user->id) }}" method="POST" onsubmit="return confirm('Delete user?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit">🗑 Delete</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

<a href="{{ url()->previous() }}">← Back</a>
@endsection
