@extends('layout.outsidehometemplate')

@section('content')
<style>
    /* General form styling */
    form {
        margin-top: 20px;
    }

    form button {
        background-color: #4CAF50;
        color: white;
        padding: 10px 20px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        font-size: 16px;
    }

    form button:hover {
        background-color: #45a049;
    }

    form input[type="text"], form select {
        margin: 10px 0;
        padding: 8px;
        font-size: 16px;
        border: 1px solid #ccc;
        border-radius: 4px;
        width: 100%;
        max-width: 300px;
        display: block;
    }

    form select {
        cursor: pointer;
    }

    /* Alert styling */
    .alert {
        color: #D8000C;
        background-color: #FFD2D2;
        padding: 10px;
        border: 1px solid #D8000C;
        margin: 10px 0;
        border-radius: 4px;
    }

    /* Dropdown visibility adjustments */
    form select option[style*="display: none"] {
        color: #ccc;
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Handle caregiver dropdowns
        const caregiverDropdowns = document.querySelectorAll('select[id^="caregiver_"]');
        caregiverDropdowns.forEach(dropdown => {
            dropdown.addEventListener('change', function () {
                updateDropdownOptions(caregiverDropdowns);
            });
        });

        // Handle patient group dropdowns
        const groupDropdowns = document.querySelectorAll('select[id^="group_"]');
        groupDropdowns.forEach(dropdown => {
            dropdown.addEventListener('change', function () {
                updateDropdownOptions(groupDropdowns);
            });
        });

        function updateDropdownOptions(dropdowns) {
            const selectedValues = Array.from(dropdowns)
                .map(dropdown => dropdown.value)
                .filter(value => value); // Get all selected values, ignoring empty ones

            dropdowns.forEach(dropdown => {
                const currentValue = dropdown.value;
                const options = dropdown.querySelectorAll('option');

                options.forEach(option => {
                    // Hide options already selected in other dropdowns, except for the current value
                    if (selectedValues.includes(option.value) && option.value !== currentValue) {
                        option.style.display = 'none';
                    } else {
                        option.style.display = 'block';
                    }
                });
            });
        }
    });
</script>
@if($level === 1 || $level === 2)
<h2>Create Roster</h2>

@if ($errors->has('roster'))
    <div class="alert">{{ $errors->first('roster') }}</div>
@endif

@if (session('status'))
    <p>{{ session('status') }}</p>
@endif

<form method="POST" action="{{ route('create_roster') }}">
    @csrf
    <button type="submit">Submit</button>
    
    <input type="text" name="roster_date" id="roster_date" 
           onfocus="(this.type='date')" onblur="(this.type='text')" 
           placeholder="{{ 'Insert date' }}">

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
        <option value="">Select Caregiver 1</option>
        @foreach($caregivers as $caregiver)
            <option value="{{ $caregiver->employee_id }}">{{ $caregiver->first_name }} {{ $caregiver->last_name }}</option>
        @endforeach
    </select>

    <select name="group_id_1" id="group_id_1" required>
        <option value="">Select Patient Group 1</option>
        @foreach($groups as $group)
            <option value="{{ $group->group_id }}">{{ $group->name }}</option>
        @endforeach
    </select>

    <select name="caregiver_2_id" id="caregiver_2_id" required>
        <option value="">Select Caregiver 2</option>
        @foreach($caregivers as $caregiver)
            <option value="{{ $caregiver->employee_id }}">{{ $caregiver->first_name }} {{ $caregiver->last_name }}</option>
        @endforeach
    </select>

    <select name="group_id_2" id="group_id_2" required>
        <option value="">Select Patient Group 2</option>
        @foreach($groups as $group)
            <option value="{{ $group->group_id }}">{{ $group->name }}</option>
        @endforeach
    </select>

    <select name="caregiver_3_id" id="caregiver_3_id" required>
        <option value="">Select Caregiver 3</option>
        @foreach($caregivers as $caregiver)
            <option value="{{ $caregiver->employee_id }}">{{ $caregiver->first_name }} {{ $caregiver->last_name }}</option>
        @endforeach
    </select>

    <select name="group_id_3" id="group_id_3" required>
        <option value="">Select Patient Group 3</option>
        @foreach($groups as $group)
            <option value="{{ $group->group_id }}">{{ $group->name }}</option>
        @endforeach
    </select>

    <select name="caregiver_4_id" id="caregiver_4_id" required>
        <option value="">Select Caregiver 4</option>
        @foreach($caregivers as $caregiver)
            <option value="{{ $caregiver->employee_id }}">{{ $caregiver->first_name }} {{ $caregiver->last_name }}</option>
        @endforeach
    </select>

    <select name="group_id_4" id="group_id_4" required>
        <option value="">Select Patient Group 4</option>
        @foreach($groups as $group)
            <option value="{{ $group->group_id }}">{{ $group->name }}</option>
        @endforeach
    </select>
</form>

<br>
<br>
<br>
<br>
<br>
<br>
<br>

@else
    <h1>Whoops! Looks like you don't have access.</h1>
<br><br><br>
<center><img src="css/not loggged in.gif" alt=""></center>
    @endif
@endsection
