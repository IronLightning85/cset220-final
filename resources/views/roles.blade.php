@extends('layout.outsidehometemplate')


@section('content')
<h2>Roles</h2>

<!-- Display status message -->
@if (session('status'))
    <p>{{ session('status') }}</p>
@endif

<table border="1">
    <tr>
        <th></th>
        <th>Role ID</th>
        <th>Role Name</th>
        <th>Access Level</th>

    </tr>

    @foreach ($roles as $role)
        <tr>
            <td></td>
            <td>{{ $role->role_id }}</td>
            <td>{{ $role->role_name }}</td>
            <td>{{ $role->level }}</td>

        </tr>
    @endforeach

    <tr>
        <form method="POST" action="{{ route('role') }}">
            @csrf <!-- Add this line to include the CSRF token -->
            <td></td>
            <td><button type="submit">Submit</button></td>
            <td><input type="text" name="role_name" id="role_name" placeholder = "Enter Role Name"></td>
            <td><input type="text" name="role_level" id="role_level" placeholder = "Enter Role Level"></td>

        </form>
    </tr>
</table>
<br><br><br><br><br>
@endsection
