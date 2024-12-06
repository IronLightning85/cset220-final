@extends('layout.OutsideHometemplate')
@section('content')
    <h1>Patient Appointment</h1>

    <!-- Display status message -->
    @if (session('status'))
        <p>{{ session('status') }}</p>
    @endif

    @if ($errors->has('input'))
        <br>
        <div class="alert">{{ $errors->first('input') }}</div>
    @endif

    @if ($previous_appointment)
        <h3>Previous Appointment</h3>
        <table>
            <tr>
                <th>Date</th>
                <th>Comment</th>
                <th>Morning Med</th>
                <th>Afternoon Med</th>
                <th>Night Med</th>
            </tr>

            <tr>
                <td>{{$previous_appointment->date}}</td>
                <td>{{$previous_appointment->comment}}</td>
                <td>{{$previous_appointment->morning_med}}</td>
                <td>{{$previous_appointment->afternoon_med}}</td>
                <td>{{$previous_appointment->night_med}}</td>
            </tr>
        </table>
    @elseif ($current_appointment->comment)
    <h3>Previous Appointment</h3>
        <table>
            <tr>
                <th>Date</th>
                <th>Comment</th>
                <th>Morning Med</th>
                <th>Afternoon Med</th>
                <th>Night Med</th>
            </tr>

            <tr>
                <td>{{$current_appointment->date}}</td>
                <td>{{$current_appointment->comment}}</td>
                <td>{{$current_appointment->morning_med}}</td>
                <td>{{$current_appointment->afternoon_med}}</td>
                <td>{{$current_appointment->night_med}}</td>
            </tr>
        </table>
    @else
        <div class="alert">No Previous Appointment</div>
    @endif

    @if ($current_appointment)
        {{-- Use carbon and php to determine today --}}
        @php
            $today = \Carbon\Carbon::today()->toDateString();
        @endphp

        @if ($current_appointment->date === $today)
            <form action="{{route('view-appointment-store')}}" method="POST">
                @csrf
                <table>
                    <tr>
                        <th>Comment</th>
                        <th>Morning Med</th>
                        <th>Afternoon Med</th>
                        <th>Night Med</th>
                    </tr>

                    <tr>
                        <td><input type="text" name="comment" id="comment" placeholder="Enter Comment" required></td>
                        <td><input type="text" name="morning_med" id="morning_med" placeholder="Enter morning Med" required></td>
                        <td><input type="text" name="afternoon_med" id="afternoon_med" placeholder="Enter afternoon med" required></td>
                        <td><input type="text" name="night_med" id="night_med" placeholder="Enter night med" required></td>
                    </tr>
                </table>
                <input type="hidden" value="{{$appointment_id}}" name="appointment_id">
                <button type="submit">Submit Prescription</button>
            </form>
        @else
            <div class="alert">Appointment is not today</div>
        @endif
    @else
    <div class="alert">Unexpected Error</div>
    @endif
    <br>
    <br>
    <br>

@endsection