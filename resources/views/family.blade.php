@extends('layout.outsidehometemplate')

@section('content')
@if($level === 5)

<center>
    <div class="content-container" style="display: block;">
        <div class="model-section">
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
        </div>
    </div>
</center>


@if ($errors->any())
    <div class="error-messages">
        @foreach ($errors->all() as $error)
            <p>{{ $error }}</p>
        @endforeach
    </div>
@endif

@if (!empty($activities))
    <h1>Activities for {{$activities->first()->first_name}} {{$activities->first()->last_name}} on {{ $date }}</h1>
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
                    <td style="color: {{ $activity->morning ? 'green' : 'red' }}">
                        {{ $activity->morning ? 'RECEIVED' : 'MISSING' }}
                      </td>
                      <td style="color: {{ $activity->afternoon ? 'green' : 'red' }}">
                        {{ $activity->afternoon ? 'RECEIVED' : 'MISSING' }}
                      </td>
                      <td style="color: {{ $activity->night ? 'green' : 'red' }}">
                        {{ $activity->night ? 'RECEIVED' : 'MISSING' }}
                      </td>
                      <td style="color: {{ $activity->breakfast ? 'green' : 'red' }}">
                        {{ $activity->breakfast ? 'RECEIVED' : 'MISSING' }}
                      </td><td style="color: {{ $activity->lunch ? 'green' : 'red' }}">
                        {{ $activity->lunch ? 'RECEIVED' : 'MISSING' }}
                      </td><td style="color: {{ $activity->dinner ? 'green' : 'red' }}">
                        {{ $activity->dinner ? 'RECEIVED' : 'MISSING' }}
                      </td>
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
