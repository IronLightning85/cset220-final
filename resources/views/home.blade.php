<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shady Shoals</title>


    

    <script>
        function showspecial() {
            var roleId = document.getElementById('role_id').value;
            
          
            var adminFields = document.getElementById('adminFields');

            var supervisorFields = document.getElementById('supervisorFields');

            var doctorFields = document.getElementById('doctorFields');

            var caregiverFields = document.getElementById('caregiverFields');

            var familyFields = document.getElementById('familyFields');
            
            var patientFields = document.getElementById('patientFields');

            adminFields.style.display = (roleId == 1) ? 'block' : 'none';

            supervisorFields.style.display = (roleId == 2) ? 'block' : 'none';

            doctorFields.style.display = (roleId == 3) ? 'block' : 'none';

            caregiverFields.style.display = (roleId == 4) ? 'block' : 'none';

            familyFields.style.display = (roleId == 5) ? 'block' : 'none';

            patientFields.style.display = (roleId == 6) ? 'block' : 'none';
          
         
        }
    </script>




</head>
<body>
    <div class="logo">
        <h1>Shady Shoals Retirement Home</h1>
    </div>
    <nav>
        <ul>

    <!--All Users UPDATE URLS WHEN CREATED-->
            <li><a href="{{ url('/logout') }}"></a>Log Out</li>
            <li><a href="{{ url('/roster') }}"></a>Roster</li>

     <!--Family UPDATE URLS WHEN CREATED-->
    <div id="familyFields" style="display: none;">
        <li><a href="{{ url('/family') }}"></a>Family Information</li>
    </div>

    <!--Patient UPDATE URLS WHEN CREATED-->
    <div id="patientFields" style="display: none;">
        <li><a href="{{ url('/patientHome') }}"></a>Patient Home</li>
    </div>

    <!-- Admin  UPDATE URLS WHEN CREATED-->
    <div id="adminFields" style="display: none;">
        <li><a href="{{ url('/appointment') }}"></a>Doctors Appointment</li>
        <li><a href="{{ url('/employee') }}"></a>Employee's List</li>
        <li><a href="{{ url('/patients') }}"></a>Patients List</li>
        <li><a href="{{ url('/unaprroved-users') }}"></a>Approve Users</li>
        <li><a href="{{ url('/new-roster') }}"></a>New Roster</li>
        <li><a href="{{ url('/report') }}"></a>Admin's Report</li>
        <li><a href="{{ url('/payment') }}"></a>Payment</li>
    </div>
    <!-- Supervisor UPDATE URLS WHEN CREATED -->
    <div id="adminFields" style="display: none;">
        <li><a href="{{ url('/appointment') }}"></a>Doctors Appointment</li>
        <li><a href="{{ url('/employee') }}"></a>Employee's List</li>
        <li><a href="{{ url('/patients') }}"></a>Patients List</li>
        <li><a href="{{ url('/unaprroved-users') }}"></a>Approve Users</li>
        <li><a href="{{ url('/new-roster') }}"></a>New Roster</li>
        <li><a href="{{ url('/report') }}"></a>Admin's Report</li>
    </div>


        </ul>
    </nav>
</header>
<main>

</body>
</html>