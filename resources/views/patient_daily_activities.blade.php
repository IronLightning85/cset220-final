@extends('layout.outsidehometemplate')

@section('content')
<div class="container">
    <h1>Patient Information</h1>

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

    <h3>Details for {{ $date }}</h3>

    @if (!$activities)
        <p>No activities found for this date.</p>
    @else
        <table class="table">
            <thead>
                <tr>
                    <th>Doctor</th>
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
@endsection