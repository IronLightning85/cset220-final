<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="css/style.php" media="screen">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shady Shoal's</title>
</head>
<body>
    
<form method="POST" action="{{ route('login') }}">
        @csrf
    <!-- /\ security thing larvael expects -->
    <label for="email">Email:</label>
    <input type="email" name="email" id="email" required>

    <label for="password">Password:</label>
    <input type="password" name="password" id="password" required>

    <button type="submit">Login</button>
</form>

@if(session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
@endif

</body>
</html>

