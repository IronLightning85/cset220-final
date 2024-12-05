@extends('layout.OutsideHometemplate')
@section('content')
<h2>Appointment</h2>
<meta name="csrf-token" content="{{ csrf_token() }}">
@if($level === 1 || $level === 2)
<!-- Display status message -->
@if (session('status'))
    <p>{{ session('status') }}</p>
@endif

@if ($errors->has('validator'))
    <br>
    <div class="alert">{{ $errors->first('validator') }}</div>
@endif

<form method="POST" action="{{ route('appointment') }}">
    @csrf <!-- Add this line to include the CSRF token -->
    <table>
        <tr>
            <th>Patient Id</th>
            <th>Patient Name</th>
            <th>Appointment Date</th>
            <th>Doctor</th>
        </tr>

        <tr>
            <td><input type="text" id="patient_id" name="patient_id" placeholder="Enter Patient ID" required></td>
            <td><p id="patient_name" name="patient_name">Enter Patient ID</p></td>
            <td><input type="date" name="appointment_date" id="appointment_date" required></td>
            <td><select id="doctor_dropdown" name="doctor_id" required>
                    <option value="">Select Doctor</option>
                </select>
            </td>
        </tr>
    </table>

    <button type="submit">Submit</button>
</form>

<br>
<br>
<br>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Function to fetch patient details
    function fetchPatientDetails() {
        let patientId = document.getElementById("patient_id").value;
        let patientNameElement = document.getElementById("patient_name");

        if (patientId) {
            // Fetch patient details from the server
            fetch(`/get-patient/${patientId}`)
                .then(response => {
                    if (response.ok) {
                        return response.json();
                    } else {
                        throw new Error('Error fetching patient details');
                    }
                })
                .then(data => {
                    // Display the patient details
                    patientNameElement.innerText = `${data.first_name} ${data.last_name}`;
                })
                .catch(error => {
                    patientNameElement.innerText = 'Patient not found';
                });
        } else {
            // If patient ID is empty, remove the patient name
            patientNameElement.innerText = 'Enter Patient ID';
        }
    }

    // Attach the 'blur' event to the input field to trigger the function when the user clicks off
    document.getElementById("patient_id").addEventListener("blur", fetchPatientDetails);

    // Handle the appointment date change to fetch doctors
    document.getElementById('appointment_date').addEventListener('change', function() {
        const selectedDate = this.value;

        fetch(`/get-doctors/${selectedDate}`, {
            method: 'GET',
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
            },
        })
        .then(response => {
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            return response.json();
        })
        .then(data => {
            const doctorDropdown = document.getElementById('doctor_dropdown');
            doctorDropdown.innerHTML = '<option value="">Select Doctor</option>'; // Clear existing options
            data.forEach(doctor => {
                const option = document.createElement('option');
                option.value = doctor.employee_id;
                option.textContent = doctor.name;
                doctorDropdown.appendChild(option);
            });
        })
        .catch(error => console.error('Error:', error));
    });
});
</script>

@else
    <h1>Whoops! Looks like you don't have access.</h1>
<br><br><br>
<center><img src="css/not loggged in.gif" alt=""></center>
@endif

@endsection