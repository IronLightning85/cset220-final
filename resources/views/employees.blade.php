@extends('layout.outsidehometemplate')


@section('content')

@if($level === 1)
<h2>Employees</h2>

<!-- Display status message -->
@if (session('status'))
    <p>{{ session('status') }}</p>
@endif

@if ($errors->has('input'))
    <br>
    <div class="alert">{{ $errors->first('input') }}</div>
@endif

<table border="1">
    <tr>

        <th>Employee ID</th>
        <th>Name</th>
        <th>Role</th>
        <th>Salary</th>
    </tr>

    @foreach ($employees as $employee)
        <tr>
            <td>{{ $employee->employee_id }}</td>
            <td>{{ $employee->first_name }} {{ $employee->last_name }}</td>
            <td>{{ $employee->role_name }}</td>
            <td>{{ $employee->salary }}</td>
        </tr>
    @endforeach

</table>

<br><br>
    
<form method="POST" action="{{ route('employee') }}">
    @csrf
    <button type="submit">Submit</button>
    <input type="number" name="employee_id" id="employee_id" placeholder = "Enter Employee ID" required>
    <input type="number" name="salary" id="salary" placeholder = "Enter New Salary" required>
</form>

<br><br><br><br><br><br><br><br><br><br>
    
@elseif($level === 2)
<h2>Employees</h2>

<!-- Display status message -->
@if (session('status'))
    <p>{{ session('status') }}</p>
@endif

@if ($errors->has('input'))
    <br>
    <div class="alert">{{ $errors->first('input') }}</div>
@endif

<table border="1">
    <tr>

        <th>Employee ID</th>
        <th>Name</th>
        <th>Role</th>
        <th>Salary</th>
    </tr>

    @foreach ($employees as $employee)
        <tr>
            <td>{{ $employee->employee_id }}</td>
            <td>{{ $employee->first_name }} {{ $employee->last_name }}</td>
            <td>{{ $employee->role_name }}</td>
            <td>{{ $employee->salary }}</td>
        </tr>
    @endforeach

</table>
<br><br><br><br><br><br><br><br><br><br>
    
@else
    <h1>Whoops! Looks like you don't have access.</h1>
<br><br><br>
<center><img src="css/not loggged in.gif" alt=""></center>
@endif



@endsection
