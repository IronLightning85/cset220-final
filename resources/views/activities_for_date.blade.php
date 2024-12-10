@extends('layout.outsidehometemplate')

@section('content')
<div class="container">
    <h1>Daily Report</h1>

    <center>
        <div class="content-container" style="display: block">
            <div class="model-section">
                <form action="{{ route('activitiesForDate') }}" method="GET" class="mb-4">
                    <label for="date">Select Date:</label>
                    <input type="date" name="date" id="date" value="{{ $date }}" required>
                    <button type="submit" class="btn btn-primary">View Report</button>
                </form>
            </div>
        </div>
    </center>


    @if ($activities->isEmpty())
        <div class="alert">No reports found for the selected date.</div>
    @else
        <table class="table">
            <thead>
                <tr>
                    <th>Patient Name</th>
                    <th>Morning Medication</th>
                    <th>Afternoon Medication</th>
                    <th>Night Medication</th>
                    <th>Breakfast</th>
                    <th>Lunch</th>
                    <th>Dinner</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($activities as $activity)
                <tr>
                    <td>{{ $activity->first_name }} {{ $activity->last_name }}</td>
                    <td style="color: {{ $activity->morning ? 'green' : 'red' }}">
                        {{ $activity->morning ? 'RECEIVED' : 'MISSING' }}
                    </td>
                    <td style="color: {{ $activity->afternoon ? 'green' : 'red' }}">
                        {{ $activity->afternoon ? 'RECEIVED' : 'MISSING' }}
                    </td>
                    <td style="color: {{ $activity->night ? 'green' : 'red' }}">
                        {{ $activity->night ? 'RECEIVED' : 'MISSING' }}
                    </td>
                    <td style="color: {{ $activity->breakfast ? 'green' : 'red' }}">
                        {{ $activity->breakfast ? 'RECEIVED' : 'MISSING' }}
                    </td>
                    <td style="color: {{ $activity->lunch ? 'green' : 'red' }}">
                        {{ $activity->lunch ? 'RECEIVED' : 'MISSING' }}
                    </td>
                    <td style="color: {{ $activity->dinner ? 'green' : 'red' }}">
                        {{ $activity->dinner ? 'RECEIVED' : 'MISSING' }}
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <br><br><br>
    @endif
</div>
@endsection