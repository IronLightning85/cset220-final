@extends('layout.outsidehometemplate')

@section('content')
@if($level === 1)
<form method="POST" action="{{ route('family.specificDateFamily') }}">
    @csrf
    <div>
        <label for="family_code">Family Code:</label>
        <input type="text" name="family_code" value="{{ old('family_code') }}" required>
    </div>
    <div>
        <label for="patient_id">Patient ID:</label>
        <input type="text" name="patient_id" value="{{ old('patient_id') }}" required>
    </div>
    <div>
        <label for="family_date">Date:</label>
        <input 
            type="text" 
            name="family_date" 
            id="family_date" 
            value="{{ old('family_date', $date ?? '') }}" 
            onfocus="(this.type='date')" 
            onblur="(this.type='text')" 
            placeholder="Select Date" 
            required>
    </div>
    <button type="submit">Submit</button>
</form>

@if ($errors->any())
    <div class="error-messages">
        @foreach ($errors->all() as $error)
            <p>{{ $error }}</p>
        @endforeach
    </div>
@endif

@if (!empty($activities))
    <h2>Activities for {{ $date }}</h2>
    <table border="1">
        <thead>
            <tr>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Morning</th>
                <th>Afternoon</th>
                <th>Night</th>
                <th>Breakfast</th>
                <th>Lunch</th>
                <th>Dinner</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($activities as $activity)
                <tr>
                    <td>{{ $activity->first_name }}</td>
                    <td>{{ $activity->last_name }}</td>
                    <td>{{ $activity->morning }}</td>
                    <td>{{ $activity->afternoon }}</td>
                    <td>{{ $activity->night }}</td>
                    <td>{{ $activity->breakfast }}</td>
                    <td>{{ $activity->lunch }}</td>
                    <td>{{ $activity->dinner }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endif



@else
    <h1>Whoops! Looks like you don't have access.</h1>
<br><br><br>
<center><img src="css/not loggged in.gif" alt=""></center>
@endif

@endsection
