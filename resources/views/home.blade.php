<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shady Shoals</title>
</head>
<body>


    <div class="logo">
        <h1>Shady Shoals Retirement Home</h1>
    </div>

    <nav>
        <ul>
            <!-- All Users -->
            <td><button onclick="location.href='{{ url('logout') }}'">Logout</button></td>
            <td><button onclick="location.href='{{ url('roster') }}'">Roster</button></td>

            <!-- Conditional content based on user role level -->
            @if($level == 1)
                <!-- Admin Content -->
                <td><button onclick="location.href='{{ url('supervisor') }}'">Supervisor Hub</button></td>
                <td><button onclick="location.href='{{ url('payment') }}'">Payment</button></td>
            @elseif($level == 2)
                <!-- Supervisor Content -->
                <td><button onclick="location.href='{{ url('supervisor') }}'">Supervisor Hub</button></td>
            @elseif($level == 3)
                <!-- Doctor Content -->
                <td><button onclick="location.href='{{ url('doctor') }}'">Doctor Home</button></td>
            @elseif($level == 4)
                <!-- Caregiver Content -->
                <td><button onclick="location.href='{{ url('caregiver') }}'">Caregiver Home</button></td>
            @elseif($level == 5)
                <!-- Family Content -->
                <td><button onclick="location.href='{{ url('family') }}'">Family Home</button></td>
            @elseif($level == 6)
                <!-- Patient Content -->
                <td><button onclick="location.href='{{ url('patient') }}'">Patient Home</button></td>
            @else
                <!-- Default Content if no level is defined -->
                <td><button onclick="location.href='{{ url('home') }}'">Dashboard</button></td>
            @endif
        </ul>
    </nav>
</body>
</html>
