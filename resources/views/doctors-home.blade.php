@extends('layout.outsidehometemplate')


@section('content')
<h2>Doctor Home</h2>

<!-- Display status message -->
@if (session('status'))
    <p>{{ session('status') }}</p>
@endif

@if ($errors->has('error'))
    <br>
    <div class="alert">{{ $errors->first('error') }}</div>
@else

    <h3>Filter Appointments</h3>
    <table>
        <tr>
            <th>Patient Name</th>
            <th>Date</th>
            <th>Comment</th>
            <th>Morning Med</th>
            <th>Afternoon Med</th>
            <th>Night Med</th>
            <th></th>
            <th></th>
        </tr>

        <tr>
            <form action="{{ route('filterAppointments') }}" method="GET">                
                <td><input type="text" name="patient_name" id="patient_name" placeholder="Enter Patient Name"></td>
                <td><input type="date" name="date"></td>
                <td><input type="text" name="comment" id="comment" placeholder="Enter Comment"></td>
                <td><input type="text" name="morning_med" id="morning_med" placeholder="Enter Morning Med"></td>
                <td><input type="text" name="afternoon_med" id="afternoon_med" placeholder="Enter Afternoon Med"></td>
                <td><input type="text" name="night_med" id="night_med" placeholder="Enter Night Med"></td>
                <td><button type="submit">Filter Appointments</button></td>
            </form>

            <td><button onclick="location.href='{{ url('doctors-home') }}'">Reset Filters</button></td>


        </tr>
    </table>

    <br><br>

    @if (!$appointments_old->isEmpty())
        <h3>Old Appointments</h3>
        <table>
            <tr><th>Patient Name</th>
                <th>Date</th>
                <th>Comment</th>
                <th>Morning Med</th>
                <th>Afternoon Med</th>
                <th>Night Med</th>
            </tr>

            @foreach ($appointments_old as $appointment)
                <tr>
                    <td>{{$appointment->first_name}} {{$appointment->last_name}}</td>
                    <td>{{$appointment->date}}</td>
                    <td>{{$appointment->comment}}</td>
                    <td>{{$appointment->morning_med}}</td>
                    <td>{{$appointment->afternoon_med}}</td>
                    <td>{{$appointment->night_med}}</td>
                </tr>
            @endforeach
        </table>  
    @else
        <div class="alert"><p>No Old Appointments</p></div>
    @endif

    <br><br>

    @if (!$appointments_upcoming->isEmpty())
        <h3>Upcoming Appointments</h3>
        <table>
            <tr><th>Patient Name</th>
                <th>Date</th>
                <th></th>
            </tr>

            @foreach ($appointments_upcoming as $appointment)
                <tr>
                    <td>{{$appointment->first_name}} {{$appointment->last_name}}</td>
                    <td>{{$appointment->date}}</td>
                    <td>
                        <form action="{{('doctors-home')}}">
                            @csrf
                            <input type="hidden" name="appointment_id" value="{{ $appointment->appointment_id }}">
                            <button type="submit">View Appointment</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </table>  
    @else
        <div class="alert"><p>No Upcoming Appointments</p></div>
    @endif

@endif

<br><br><br>
    

@endsection
