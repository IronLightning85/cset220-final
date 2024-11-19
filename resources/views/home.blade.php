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
    <img src="css/Shady Shoal’s (3).png" alt="">
    </div>

    <nav>
        <ul>

        @if($level === null)
        <!-- Display error if user is not logged in -->
        <h1>Error: Please log in</h1>

    @else
    <td><button onclick="location.href='{{ route('logout') }}'">Logout</button></td>

    <td><button onclick="location.href='{{ url('roster') }}'">Roster</button></td>
    @endif

                <!-- Conditional content based on user role level -->
                @if($level == 1)
                    <td><button onclick="location.href='{{ url('supervisor') }}'">Supervisor Hub</button></td>
                    <td><button onclick="location.href='{{ url('payment') }}'">Payment</button></td>
                @elseif($level == 2)
                    <td><button onclick="location.href='{{ url('supervisor') }}'">Supervisor Hub</button></td>
                @elseif($level == 3)
                    <td><button onclick="location.href='{{ url('doctor') }}'">Doctor Home</button></td>
                @elseif($level == 4)
                    <td><button onclick="location.href='{{ url('caregiver') }}'">Caregiver Home</button></td>
                @elseif($level == 5)
                    <td><button onclick="location.href='{{ url('family') }}'">Family Home</button></td>
                @elseif($level == 6)
                    <td><button onclick="location.href='{{ url('patient') }}'">Patient Home</button></td>
                @else
                    <td><button onclick="location.href='{{ url('home') }}'">Dashboard</button></td>
                @endif

        </ul>
    </nav>

    @if($level === null)
        <!-- Display error if user is not logged in -->
        <h1>Error: Please log in</h1>
        <td><button onclick="location.href='{{ url('login') }}'">Login</button></td>

    @else

    @endif



    <div class="footer">
<h4>Shady Shoals LLC</h4>
    </div>
</body>
</html>
