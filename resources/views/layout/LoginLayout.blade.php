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
        <button onclick="location.href='{{ route('landing') }}'">Home</button>
    </div>
    <img src="css/Shady Shoal’s (4).png" alt="">
</div>


    @yield('content')



    <div class="footer">
<h4>Shady Shoals LLC</h4>
    </div>
</body>
</html>
