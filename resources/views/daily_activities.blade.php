@extends('layout.outsidehometemplate')

@section('content')
<div class="container">
    <h1>Patient Daily Activities</h1>

    @if (empty($patients))
        <p>No patients are assigned to your group for today.</p>
    @else
        <form action="{{ route('updateDailyActivities') }}" method="POST">
            @csrf
            <table class="table">
                <thead>
                    <tr>
                        <th>Patient Name</th>
                        <th>Morning</th>
                        <th>Afternoon</th>
                        <th>Night</th>
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
@endsection
