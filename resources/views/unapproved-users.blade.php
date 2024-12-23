@extends('layout.OutsideHomeTemplate')


@section('content')
@if($level === 1 || $level === 2)

<h2>Unapproved Users</h2>

<!-- Display status message -->
@if (session('status'))
    <div class="alert-good" style="text-align: center">{{ session('status') }}</div>
@endif

@if ($unapprovedUsers->count() > 0)
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
@else
<div class="alert" style="text-align: center">No unapproved users to approve</div>
@endif

@else
    <h1>Whoops! Looks like you don't have access.</h1>
<br><br><br>
<center><img src="css/not loggged in.gif" alt=""></center>
@endif



<br><br><br>

@endsection
