@extends('layout.outsidehometemplate')


@section('content')
<script>
        document.addEventListener('DOMContentLoaded', function () {
            // Get all the dropdowns
            const dropdowns = document.querySelectorAll('select[id^="caregiver_"]');

            // Add an event listener to each dropdown
            dropdowns.forEach(dropdown => {
                dropdown.addEventListener('change', function () {
                    updateDropdownOptions();
                });
            });

            function updateDropdownOptions() {
                // Get selected values
                const selectedValues = Array.from(dropdowns)
                    .map(dropdown => dropdown.value)
                    .filter(value => value); // Exclude empty values

                dropdowns.forEach(dropdown => {
                    const currentValue = dropdown.value; // Keep the current value
                    const options = dropdown.querySelectorAll('option');

                    options.forEach(option => {
                        if (selectedValues.includes(option.value) && option.value !== currentValue) {
                            option.style.display = 'none'; // Hide already selected options
                        } else {
                            option.style.display = 'block'; // Show available options
                        }
                    });
                });
            }
        });
    </script>

    <h2>Create Roster</h2>

    @if ($errors->has('roster'))
        <div class="alert">{{ $errors->first('roster') }}</div>
    @endif

    <!-- Display status message -->
    @if (session('status'))
        <p>{{ session('status') }}</p>
    @endif

    <form method="POST" action="{{ route('create_roster') }}">
            @csrf <!-- Add this line to include the CSRF token -->
            <button type="submit">Submit</button>
            
            <input type="text" name="roster_date" id="roster_date" onfocus="(this.type='date')" onblur="(this.type='text')" placeholder = "{{$date}}">
            
            <select name="supervisor_id" id="supervisor_id" required>
                <option value="">Select Supervisor</option>
                @foreach($supervisors as $supervisor)
                    <option value="{{ $supervisor->employee_id }}">{{ $supervisor->first_name }} {{ $supervisor->last_name }}</option>
                @endforeach
            </select>

            <select name="doctor_id" id="doctor_id" required>
                <option value="">Select Doctor</option>
                @foreach($doctors as $doctor)
                    <option value="{{ $doctor->employee_id }}">{{ $doctor->first_name }} {{ $doctor->last_name }}</option>
                @endforeach
            </select>

            <select name="caregiver_1_id" id="caregiver_1_id" required>
                <option value="">Select Cargiver 1</option>
                @foreach($caregivers as $caregiver)
                    <option value="{{ $caregiver->employee_id }}">{{ $caregiver->first_name }} {{ $caregiver->last_name }}</option>
                @endforeach
            </select>

            <select name="caregiver_2_id" id="caregiver_2_id" required>
                <option value="">Select Cargiver 2</option>
                @foreach($caregivers as $caregiver)
                    <option value="{{ $caregiver->employee_id }}">{{ $caregiver->first_name }} {{ $caregiver->last_name }}</option>
                @endforeach
            </select>

            <select name="caregiver_3_id" id="caregiver_3_id" required>
                <option value="">Select Cargiver 3</option>
                @foreach($caregivers as $caregiver)
                    <option value="{{ $caregiver->employee_id }}">{{ $caregiver->first_name }} {{ $caregiver->last_name }}</option>
                @endforeach
            </select>

            <select name="caregiver_4_id" id="caregiver_4_id" required>
                <option value="">Select Cargiver 4</option>
                @foreach($caregivers as $caregiver)
                    <option value="{{ $caregiver->employee_id }}">{{ $caregiver->first_name }} {{ $caregiver->last_name }}</option>
                @endforeach
            </select>
    </form>
    
@endsection

