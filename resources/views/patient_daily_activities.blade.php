@extends('layout.outsidehometemplate')


@section('content')
@if($level === 6)
<div class="container">
    <h1>Patient Information</h1>

    <center>
        <div class="content-container" style="display: block;">
            <div class="model-section">
                <p>
                    <strong>Name:</strong> {{ $user->first_name }} {{ $user->last_name }}
                    <span style="margin-left: 20px;">
                        <strong>Patient ID:</strong> {{ $patient->patient_id }}
                    </span>
                </p>

                <form method="GET" action="{{ route('patientHome') }}">
                    <div class="form-group">
                        <label for="date">Select Date:</label>
                        <input type="date" name="date" id="date" class="form-control" value="{{ $date }}">
                    </div>
                    <button type="submit" class="btn btn-primary">Search</button>
                </form>
            </div>
        </div>
    </center>

    <h3>Details for {{ $date }}</h3>

    @if (!$activities)
        <div class="alert" style="text-align: center">No activities found for this date.</div>
        <br>
        <br>
        <br>
    @else
        <table class="table">
            <thead>
                <tr>
                    <th>Doctor</th>
                    <th>Appointment</th>
                    <th>Caregiver</th>
                    <th>Morning Medication</th>
                    <th>Afternoon Medication</th>
                    <th>Night Medication</th>
                    <th>Breakfast</th>
                    <th>Lunch</th>
                    <th>Dinner</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>{{ $doctorName }}</td>
                    <td>{{ $appointmentStatus }}</td>
                    <td>{{ $caregiverName }}</td>
                    <td style="color: {{ $activities->morning ? 'green' : 'red' }}">
                        {{ $activities->morning ? 'RECEIVED' : 'MISSING' }}
                    </td>
                    <td style="color: {{ $activities->afternoon ? 'green' : 'red' }}">
                        {{ $activities->afternoon ? 'RECEIVED' : 'MISSING' }}
                    </td>
                    <td style="color: {{ $activities->night ? 'green' : 'red' }}">
                        {{ $activities->night ? 'RECEIVED' : 'MISSING' }}
                    </td>
                    <td style="color: {{ $activities->breakfast ? 'green' : 'red' }}">
                        {{ $activities->breakfast ? 'RECEIVED' : 'MISSING' }}
                    </td>
                    <td style="color: {{ $activities->lunch ? 'green' : 'red' }}">
                        {{ $activities->lunch ? 'RECEIVED' : 'MISSING' }}
                    </td>
                    <td style="color: {{ $activities->dinner ? 'green' : 'red' }}">
                        {{ $activities->dinner ? 'RECEIVED' : 'MISSING' }}
                    </td>
                </tr>
            </tbody>
        </table>
        <br><br><br>
    @endif
</div>

@else
    <h1>Whoops! Looks like you don't have access.</h1>
<br><br><br>
<center><img src="css/not loggged in.gif" alt=""></center>
@endif

@endsection