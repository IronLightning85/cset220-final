<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="css/style.php" media="screen">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shady Shoal's</title>
</head>
<body>
    


</body>
</html>

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

        @if($level === null)
        <!-- Display error if user is not logged in -->
        <h1>Please log in</h1>

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
                <h3>Make an Account if you don't have one.</h3>
                <td><button onclick="location.href='{{ url('register') }}'">Register</button></td>
                @endif

        </ul>
    </nav>

    @if($level === null)
    <form method="POST" action="{{ route('login') }}">
        @csrf
    <!-- /\ security thing larvael expects -->
    <label for="email">Email:</label>
    <input type="email" name="email" id="email" required>

    <label for="password">Password:</label>
    <input type="password" name="password" id="password" required>

    <button type="submit">Login</button>
</form>

<!-- Check if there are errors -->
@if ($errors->has('login'))
    <script>
        alert("{{ $errors->first('login') }}");
    </script>
@endif

    @endif

    

</body>
</html>
