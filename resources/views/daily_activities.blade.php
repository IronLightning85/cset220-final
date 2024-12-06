@extends('layout.outsidehometemplate')

@section('content')
@if($level === 4)

<div class="container">
    <h1>Patient Daily Activities</h1>

    @if (empty($patients))
        <div class="alert" style="text-align: center">No patients are assigned to your group for today.</div>
    @else
        <form action="{{ route('updateDailyActivities') }}" method="POST">
            @csrf
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
                    @foreach ($patients as $patient)
                    <tr>
                        <td>{{ $patient->first_name }} {{ $patient->last_name }}</td>
                        <td><input type="checkbox" name="activities[{{ $patient->patient_id }}][morning]" {{ $patient->morning ? 'checked' : '' }}></td>
                        <td><input type="checkbox" name="activities[{{ $patient->patient_id }}][afternoon]" {{ $patient->afternoon ? 'checked' : '' }}></td>
                        <td><input type="checkbox" name="activities[{{ $patient->patient_id }}][night]" {{ $patient->night ? 'checked' : '' }}></td>
                        <td><input type="checkbox" name="activities[{{ $patient->patient_id }}][breakfast]" {{ $patient->breakfast ? 'checked' : '' }}></td>
                        <td><input type="checkbox" name="activities[{{ $patient->patient_id }}][lunch]" {{ $patient->lunch ? 'checked' : '' }}></td>
                        <td><input type="checkbox" name="activities[{{ $patient->patient_id }}][dinner]" {{ $patient->dinner ? 'checked' : '' }}></td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <button type="submit" class="btn btn-primary">Update</button>
        </form>
    @endif
</div>


@else
    <h1>Whoops! Looks like you don't have access.</h1>
<br><br><br>
<center><img src="css/not loggged in.gif" alt=""></center>
@endif

@endsection
