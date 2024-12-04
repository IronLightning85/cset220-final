@extends('layout.outsidehometemplate')


@section('content')
<h2>Doctor Home</h2>

<!-- Display status message -->
@if (session('status'))
    <p>{{ session('status') }}</p>
@endif

@if ($errors->has('error'))
    <br>
    <div class="alert">{{ $errors->first('error') }}</div>
@else

    @if ($appointments_old)
        <h3>Old Appointments</h3>
        <table>
            <tr><th>Patient Name</th>
                <th>Date</th>
                <th>Comment</th>
                <th>Morning Med</th>
                <th>Afternoon Med</th>
                <th>Night Med</th>
            </tr>

            @foreach ($appointments_old as $appointment)
                <tr></tr>
                <tr>{{$appointment->$date}}</tr>
            @endforeach
        </table>
    @endif

@endif

<br><br><br>
    

@endsection
