@extends('layout.LoginLayout')

@section('content')


<link href="{{ asset('css/login.css') }}" rel="stylesheet" />
    <nav>
        @if($level === null)
        <h1>If you don't have an account Register.</h1>
        
        <center><button onclick="location.href='{{ route('register') }}'">Register</button></center> 
 
        @else
        <center>
        <h1>Error Already Logged in</h1>
        <button onclick="location.href='{{ route('logout') }}'">Logout</button>
        <button onclick="location.href='{{ route('home') }}'">Home</button>
        </center> 
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


    @endsection

