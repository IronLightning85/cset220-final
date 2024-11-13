<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shady Shoal's</title>
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
    <input type="text" name="role_id" id="role_id" required>


    <button type="submit">Register</button>
</form>

@if(session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
@endif

</body>
</html>


