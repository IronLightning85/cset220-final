<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Patients</title>
</head>
<body>
    <h2>Patients</h2>

    <!-- Display status message -->
    @if (session('status'))
        <p>{{ session('status') }}</p>
    @endif

    <table border="1">
        <tr>
            <th></th>
            <th>Patient ID</th>
            <th>Name</th>
            <th>Age</th>
            <th>Emergency Contact</th>
            <th>Emergency Contact Relation</th>
            <th>Admission Date</th>
        </tr>

        @foreach ($patients as $patient)
            <tr>
                <td></td>
                <td>{{ $patient->patient_id }}</td>
                <td>{{ $patient->first_name }} {{ $patient->last_name }}</td>
                <td>{{ $patient->age }}</td>
                <td>{{ $patient->emergency_contact }}</td>
                <td>{{ $patient->contact_relation }}</td>
                <td>{{ $patient->admission_date }}</td>
            </tr>
        @endforeach

        <tr>
            <form method="POST" action="{{ route('patient') }}">
                <td><button type="submit">Search</button></td>
                <td><input type="text" name="patient_id" id="patient_id" placeholder = "Enter Patient ID"></td>
                <td><input type="text" name="name" id="name" placeholder = "Enter Patient Name"></td>
                <td><input type="text" name="age" id="age" placeholder = "Enter Patient Age"></td>
                <td><input type="text" name="emergency_contact" id="emergency_contact" placeholder = "Enter Emergency Contact"></td>
                <td><input type="text" name="emergency_contact_relation" id="emergency_contact_relation" placeholder = "Enter Emergency Relation"></td>
                <td><input type="text" name="admission_date" id="admission_date" placeholder = "Enter Admission Date"></td>

            </form>
        </tr>
    </table>
</body>
</html>