@extends('layout.OutsideHometemplate')


@section('content')
<h2>Roster</h2>

<!-- Display status message -->
@if (session('status'))
    <p>{{ session('status') }}</p>
@endif

<form method="POST" action="{{ route('roster') }}">
        @csrf <!-- Add this line to include the CSRF token -->
        <button type="submit">Submit</button>
        <input type="text" name="roster_date" id="roster_date" onfocus="(this.type='date')" onblur="(this.type='text')" placeholder = "{{$date}}">
</form>

 @if ($errors->has('roster'))
        <br>
        <div class="alert">{{ $errors->first('roster') }}</div>

 @else


    <br><br>

    <table>
        <tr>
            <th>Supervisor</th>
            <th>Doctor</th>
            <th>Caregiver 1</th>
            <th>Caregiver 2</th>
            <th>Caregiver 3</th>
            <th>Caregiver 4</th>


        </tr>

    
        <tr>
            <td>{{ $supervisor->first_name }} {{ $supervisor->last_name }}</td>
            <td>{{ $doctor->first_name }} {{ $doctor->last_name }}</td>
            <td>{{ $caregiver_1->first_name }} {{ $caregiver_1->last_name }}</td>
            <td>{{ $caregiver_2->first_name }} {{ $caregiver_2->last_name }}</td>
            <td>{{ $caregiver_3->first_name }} {{ $caregiver_3->last_name }}</td>
            <td>{{ $caregiver_4->first_name }} {{ $caregiver_4->last_name }}</td>
        </tr>

    </table>
    <br><br><br><br><br>
@endif


@endsection
