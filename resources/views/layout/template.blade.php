<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="{{ asset('css/styles.css') }}" rel="stylesheet">
    <title>Shady Shoals</title>
</head>
<body>
<div class="logo">
    <div class="logout">
        <button onclick="location.href='{{ route('logout') }}'">Logout</button>
    </div>
    <img src="css/Shady Shoal’s (4).png" alt="">
</div>


<div class="error-nav">

        @if($level === null)
        <!-- Display error if user is not logged in -->
        <h1>Error: Make an account or Log in</h1>
</div>
    @else

    <nav>
        <ul>
<div class="nav">

    <td><button onclick="location.href='{{ url('roster') }}'">Roster</button></td>
    @endif

                <!-- Conditional content based on user role level -->
                @if($level == 1)
                    <td><button onclick="location.href='{{ url('create-roster') }}'">New Roster</button></td>
                    <td><button onclick="location.href='{{ url('payment') }}'">Payment</button></td>
                    <td><button onclick="location.href='{{ url('unapproved-users') }}'">Approve Users</button></td>
                    <td><button onclick="location.href='{{ url('employee') }}'">Employees</button></td>
                    <td><button onclick="location.href='{{ url('patient') }}'">Patients</button></td>
                    <td><button onclick="location.href='{{ url('report') }}'">Admin Report</button></td>
                    <td><button onclick="location.href='{{ url('doctors-appointment') }}'">Doctor's Appoinment</button></td>
                    {{-- <form action="{{ route('admin.apply-charges') }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-warning">Apply Daily Charges</button>
                    </form> --}}
                    <td><button onclick="location.href='{{ url('role') }}'">Roles</button></td>
                @elseif($level == 2)
                    <td><button onclick="location.href='{{ url('create-roster') }}'">New Roster</button></td>
                    <td><button onclick="location.href='{{ url('payment') }}'">Payment</button></td>
                    <td><button onclick="location.href='{{ url('unapproved-users') }}'">Approve Users</button></td>
                    <td><button onclick="location.href='{{ url('employee') }}'">Employees</button></td>
                    <td><button onclick="location.href='{{ url('patient') }}'">Patients</button></td>
                    <td><button onclick="location.href='{{ url('report') }}'">Admin Report</button></td>
                    <td><button onclick="location.href='{{ url('doctors-appointment') }}'">Docters Appoinment</button></td>
                @elseif($level == 3)
                    <td><button onclick="location.href='{{ url('doctors-home') }}'">Doctors Home</button></td>
                    <td><button onclick="location.href='{{ url('doctors-patient') }}'">Doctors Patient</button></td>
                    <td><button onclick="location.href='{{ url('patient') }}'">Patients</button></td>
                @elseif($level == 4)
                <td><button onclick="location.href='{{ url('patient') }}'">Patients</button></td>
                <td><button onclick="location.href='{{ url('caregiver-home') }}'">Caregiver Home</button></td>
                @elseif($level == 5)
                    <td><button onclick="location.href='{{ url('family') }}'">Family Home</button></td>
                @elseif($level == 6)
                    <td><button onclick="location.href='{{ url('patient-home') }}'">Patient Home</button></td>
                @else
            <div class="error-nav">
            
                <center><td><button onclick="location.href='{{ url('register') }}'">Register</button></td></center>

            </div>
                @endif

        </ul>
    </nav>
    <div class="error-nav">
    @if($level === null)
        <!-- Display error if user is not logged in -->
        <center><td><button onclick="location.href='{{ url('login') }}'">Login</button></td> </center>

    </div>
    <br><br><br>
    <center><img src="css/not loggged in.gif" alt=""></center>
    @else
</div>
    @yield('content')
    @endif



    <div class="footer">
<h4>Shady Shoals LLC</h4>
    </div>
</body>
</html>
