<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shady Shoals</title>
    <link href="{{ asset('css/login.css') }}" rel="stylesheet" />
</head>
<body>
    <div class="logo">
      <img src="css/Shady Shoal’s (3).png" alt="">
    </div>
<br><br><br><br>
    <nav>
        @if($level === null)
        <h1>Please log in</h1>
        @else
        <button onclick="location.href='{{ route('logout') }}'">Logout</button>
        @endif
    </nav>

    @if($level === null)
    <form method="POST" action="{{ route('login') }}">
        @csrf
        <label for="email">Email:</label>
        <input type="email" name="email" id="email" placeholder="Enter your email" required>

        <label for="password">Password:</label>
        <input type="password" name="password" id="password" placeholder="Enter your password" required>

        <button type="submit">Login</button>
    </form>

    @if ($errors->has('login'))
    <div class="alert">{{ $errors->first('login') }}</div>
    @endif
    @endif



    <div class="footer">
<h4>Shady Shoals LLC</h4>
    </div>
</body>
</html>
