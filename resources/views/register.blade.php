<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shady Shoal's</title>
    <script>
        function showAdditionalFields() {
            var roleId = document.getElementById('role_id').value;
            var patientFields = document.getElementById('patientFields');
            var familyFields = document.getElementById('familyFields');

            patientFields.style.display = (roleId == 6) ? 'block' : 'none';
            familyFields.style.display = (roleId == 5) ? 'block' : 'none';
        }
    </script>
</head>
<body>

<form method="POST" action="{{ route('register') }}">
    @csrf

    <label for="first_name">First Name</label>
    <input type="text" name="first_name" id="first_name" required>

    <label for="last_name">Last Name</label>
    <input type="text" name="last_name" id="last_name" required>

    <label for="phone">Phone Number</label>
    <input type="text" name="phone" id="phone" required>

    <label for="dob">Date of Birth</label>
    <input type="date" name="dob" id="dob" required>

    <label for="email">Email:</label>
    <input type="email" name="email" id="email" required>

    <label for="password">Password:</label>
    <input type="password" name="password" id="password" required>

    <label for="password_confirmation">Confirm Password:</label>
    <input type="password" name="password_confirmation" id="password_confirmation" required>

    <label for="role_id">Role ID:</label>
    <input type="number" name="role_id" id="role_id" required onchange="showAdditionalFields()">

    <div id="familyFields" style="display: none;">
        <label for="patient_relation">Patient Relation:</label>
        <input type="text" name="patient_relation" id="patient_relation">
    </div>

    <div id="patientFields" style="display: none;">
        <label for="emergency_contact">Emergency Contact:</label>
        <input type="text" name="emergency_contact" id="emergency_contact">

        <label for="contact_relation">Contact Relation:</label>
        <input type="text" name="contact_relation" id="contact_relation">

        <label for="family_code">Family Code:</label>
        <input type="text" name="family_code" id="family_code">
    </div>

    <button type="submit">Register</button>
</form>

@if(session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
@endif

</body>
</html>
