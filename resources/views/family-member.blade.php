@extends('OutsideHomeTemplate.template')

@section('content')
<form method="POST" action="{{ route('family.specificDateFamily') }}">
    @csrf
    <!-- Date Input -->
    <label for="roster_date">Date:</label>
    <input type="text" 
           id="roster_date" 
           name="family_date" 
           value="{{ old('family_date', $date ?? '') }}" 
           onfocus="(this.type='date')" 
           onblur="(this.type='text')" 
           placeholder="Select Date">

    <!-- Family Code -->
    <label for="family_code">Family Code:</label>
    <input type="text" id="family_code" name="family_code" value="{{ old('family_code') }}" placeholder="Enter Family Code">

    <!-- Patient ID -->
    <label for="patient_id">Patient ID:</label>
    <input type="text" id="patient_id" name="patient_id" value="{{ old('patient_id') }}" placeholder="Enter Patient ID">

    <!-- Buttons -->
    <button type="submit">Ok</button>
    <button type="reset">Cancel</button>
</form>

<!-- Display Validation Errors -->
@if ($errors->any())
    <div>
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<!-- Display Patient Data (if available) -->
@if (isset($patients))
    <h2>Daily Activities</h2>
    <table border="1">
        <thead>
            <tr>
                <th>Doctor's Name</th>
                <th>Doctor's Appointment</th>
                <th>Caregiver's Name</th>
                <th>Morning Medicine</th>
                <th>Afternoon Medicine</th>
                <th>Night Medicine</th>
                <th>Breakfast</th>
                <th>Lunch</th>
                <th>Dinner</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($patients as $patient)
                <tr>
                    <td>{{ $patient->doctor_name }}</td>
                    <td>{{ $patient->appointment_time }}</td>
                    <td>{{ $patient->caregiver_name }}</td>
                    <td>{{ $patient->morning }}</td>
                    <td>{{ $patient->afternoon }}</td>
                    <td>{{ $patient->night }}</td>
                    <td>{{ $patient->breakfast }}</td>
                    <td>{{ $patient->lunch }}</td>
                    <td>{{ $patient->dinner }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endif
@endsection
