@extends('layout.outsidehometemplate')


@section('content')
<h2>Approved Patients</h2>

<!-- Display status message -->
@if (session('status'))
    <p>{{ session('status') }}</p>
@endif

<!-- Table of approved patients -->
<table border="1">
    <tr>
        <th>Patient ID</th>
        <th>Patient Name</th>
        <th>Group</th>
        <th>Admission Date</th>
    </tr>
    @foreach ($approvedPatients as $patient)
        <tr>
            <td>{{ $patient->patient_id }}</td>
            <td>{{ $patient->first_name }} {{ $patient->last_name }}</td>
            <td></td>
            <td>
                <!-- Form to update admission date for each patient -->
                <form action="{{ route('update-admission-date', $patient->patient_id) }}" method="POST">
                    @csrf
                    <!-- Format admission_date to YYYY-MM-DD for date input compatibility -->
                    <input type="date" name="admission_date" 
                           value="{{ $patient->admission_date ? \Carbon\Carbon::parse($patient->admission_date)->format('Y-m-d') : '' }}" 
                           required>
                    <button type="submit">Update Date</button>
                </form>
            </td>
        </tr>
    @endforeach
</table>
@endsection
