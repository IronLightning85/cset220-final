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
    <img src="css/Shady Shoal’s (4).png" alt="Shady Shoals Logo">
</div>



<nav>
    <ul>
        <div class="nav">
            @if($level === null)
                <button onclick="location.href='{{ url('login') }}'">Login</button>
                <button onclick="location.href='{{ url('register') }}'">Register</button>
            @else
                <button onclick="location.href='{{ route('logout') }}'">Logout</button>
                <button onclick="location.href='{{ route('home') }}'">Home</button>
            @endif
        </div>
    </ul>
</nav>

<div class="content-container">
    <div class="model-section">
        <img src="css/mmbb.jpeg" alt="Shady Shoals Rest Home Image">
        <p>
            Shady Shoals Rest Home is a retirement home located in Bikini Bottom, across town from Conch Street. 
            Known for its warm hospitality, the rest home serves as a haven for retired citizens and superheroes alike. 
            It is famously the home of Mermaid Man and Barnacle Boy, who occasionally emerge from retirement for adventures. 
            The establishment boasts cozy accommodations, recreational activities, and a sense of community for its residents.
        </p>
    </div>

    <div class="model-section">
        <img src="css/Shady Shoal’s (5).png" alt="Shady Shoals Rest Home Image">
        <p>
            Welcome to The Shady Shoals Newsletter. This newsletter is your go to guide for your time at Shady Shoals. Get the latest scoop on Dorsal Dan's bingo winning streak, Barnacle Boy's daring spandex choices at water aerobics, 
            and the ongoing mystery of the midnight snack bandit swiping Jello cups. Enjoy exclusive deals like half-off Krabby Patties at the cafeteria, crack the brain-teasing crossword, puzzle and catch the hottest rumors straight from the shuffleboard court.
            Sign For our newsletter today! 
        </p>

    <form>
        <label for="email">Email Address:</label>
        <input type="email" id="email" name="email" required>
        <button type="submit">Submit</button>
    </form>
    </div>
</div>


<div class="footer">
    <h4>Shady Shoals LLC</h4>
</div>
</body>
</html>
