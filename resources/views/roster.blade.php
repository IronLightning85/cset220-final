@extends('layout.OutsideHometemplate')


@section('content')
<h1>Roster</h1>

<!-- Display status message -->
@if (session('status'))
    <p>{{ session('status') }}</p>
@endif

<center>
    <div class="content-container" style="display: block;">
        <div class="model-section">
            <form method="POST" action="{{ route('roster') }}">
                @csrf <!-- Add this line to include the CSRF token -->
                <label for="roster_date">Date:</label>
                <input type="text" value="{{ old('roster_date', $date) }}" name="roster_date" id="roster_date" onfocus="(this.type='date')" onblur="(this.type='text')" placeholder = "{{old('roster_date', $date) }}">
                <button type="submit">Submit</button>
            </form>
        </div>
    </div>
</center>

@if ($errors->has('roster'))
    <br>
    <div class="alert" style="text-align: center">{{ $errors->first('roster') }}</div>
    <br><br><br>
@else


    <br>

    <h1>Roster for {{$date}}</h1>

    <table>
        <tr>
            <th>Supervisor</th>
            <th>Doctor</th>
            <th>Caregiver 1 / Assigned Group</th>
            <th>Caregiver 2 / Assigned Group</th>
            <th>Caregiver 3 / Assigned Group</th>
            <th>Caregiver 4 / Assigned Group</th>
        </tr>

    
        <tr>
            <td>{{ $supervisor->first_name }} {{ $supervisor->last_name }}</td>
            <td>{{ $doctor->first_name }} {{ $doctor->last_name }}</td>
            <td>{{ $caregiver_1->first_name }} {{ $caregiver_1->last_name }}</td>
            <td>{{ $caregiver_2->first_name }} {{ $caregiver_2->last_name }}</td>
            <td>{{ $caregiver_3->first_name }} {{ $caregiver_3->last_name }}</td>
            <td>{{ $caregiver_4->first_name }} {{ $caregiver_4->last_name }}</td>
        </tr>

        <tr>
            <td></td>
            <td></td>
            <td>{{ $group_1->name }}</td>
            <td>{{ $group_2->name }}</td>
            <td>{{ $group_3->name }}</td>
            <td>{{ $group_4->name }}</td>
        </tr>

    </table>
    <br><br><br><br><br>
@endif


@endsection
