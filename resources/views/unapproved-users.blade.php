@extends('layout.OutsideHomeTemplate')


@section('content')
<h2>Unapproved Users</h2>

<!-- Display status message -->
@if (session('status'))
    <p>{{ session('status') }}</p>
@endif

<table border="1">
    <tr>
        <th>User ID</th>
        <th>First Name</th>
        <th>Last Name</th>
        <th>Email</th>
        <th>Actions</th>
    </tr>
    @foreach ($unapprovedUsers as $user)
        <tr>
            <td>{{ $user->user_id }}</td>
            <td>{{ $user->first_name }}</td>
            <td>{{ $user->last_name }}</td>
            <td>{{ $user->email }}</td>
            <td>
                <form action="{{ route('approve-user', $user->user_id) }}" method="POST" style="display:inline;">
                    @csrf
                    <button type="submit">Approve</button>
                </form>
                <form action="{{ route('deny-user', $user->user_id) }}" method="POST" style="display:inline;">
                    @csrf
                    <button type="submit">Deny</button>
                </form>
            </td>
        </tr>
    @endforeach
</table>
@endsection
