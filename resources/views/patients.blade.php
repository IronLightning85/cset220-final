@extends('layout.outsidehometemplate')


@section('content')
@if($level === 1 || $level === 2 || $level === 3 || $level === 4)

<h2>Patients</h2>

<!-- Display status message -->
@if (session('status'))
    <p>{{ session('status') }}</p>
@endif

@if ($errors->has('patient'))
    <div class="alert">{{ $errors->first('patient') }}</div>
@endif

<table border="1">
    <tr>
      
        <th>Patient ID</th>
        <th>Name</th>
        <th>Age</th>
        <th>Emergency Contact</th>
        <th>Emergency Contact Relation</th>
        <th>Admission Date</th>
    </tr>

    @foreach ($patients as $patient)
        <tr>
      
            <td>{{ $patient->patient_id }}</td>
            <td>{{ $patient->first_name }} {{ $patient->last_name }}</td>
            <td>{{ $patient->age }}</td>
            <td>{{ $patient->emergency_contact }}</td>
            <td>{{ $patient->contact_relation }}</td>
            <td>{{ $patient->admission_date }}</td>
        </tr>
    @endforeach
    </table>
    <table>
    <tr>
    <tr>
   
      <th>Patient ID</th>
      <th>Name</th>
      <th>Age</th>
      <th>Emergency Contact</th>
      <th>Emergency Contact Relation</th>
      <th>Admission Date</th>
  </tr>
        <form method="POST" action="{{ route('patient') }}">
            @csrf

            <td><input type="number" name="patient_id" id="patient_id" placeholder = "Enter Patient ID"></td>
            <td><input type="text" name="name" id="name" placeholder = "Enter Patient Name"></td>
            <td><input type="number" name="age" id="age" placeholder = "Enter Patient Age"></td>
            <td><input type="text" name="emergency_contact" id="emergency_contact" placeholder = "Enter Emergency Contact"></td>
            <td><input type="text" name="emergency_contact_relation" id="emergency_contact_relation" placeholder = "Enter Emergency Relation"></td>
            <td><input type="date" name="admission_date" id="admission_date" placeholder = "Enter Admission Date"></td>
            </tr>
            </table>
            <td><button type="submit">Search</button></td>
        </form>

<form action="{{ route('patient') }}" method="GET">
    <button type="submit" class="btn btn-secondary">Reset Search</button>
</form>
<br><br><br><br>
@else
    <h1>Whoops! Looks like you don't have access.</h1>
<br><br><br>
<center><img src="css/not loggged in.gif" alt=""></center>
@endif

@endsection
