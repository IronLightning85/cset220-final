@extends('layout.template')

@section('content')
    <h1>Welcome {{ $first_name }}</h1>
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
<br><br><br>
@endsection
