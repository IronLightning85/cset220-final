@extends('layout.outsidehometemplate')
@section('content')
<script>
// Wait for the DOM to fully load
document.addEventListener('DOMContentLoaded', function () {
    // Loop through each row in the table
    document.querySelectorAll('table tr').forEach(row => {
        // Find the dropdown and patient group_id in the current row
        const select = row.querySelector('select[name="group_id"]');
        const patientGroupId = select ? select.dataset.groupId : null;

        if (select) {
            // If patientGroupId is not null, select the corresponding option
            if (patientGroupId) {
                Array.from(select.options).forEach(option => {
                    if (option.value === patientGroupId) {
                        // Set the selected option
                        option.selected = true;
                    }
                });
            } 
            else {
                // If patientGroupId is null, ensure no option is pre-selected
                select.selectedIndex = 0;
            }
        }
    });
});
</script>

<h2>Approved Patients</h2>

<!-- Display status message -->
@if (session('status'))
    <p>{{ session('status') }}</p>
@endif

<!-- Table of approved patients -->
<table border="1">
    <tr>
        <th>Patient ID</th>
        <th>Patient Name</th>
        <th>Group</th>
        <th>Admission Date</th>
        <th>Update</th>
    </tr>

    @foreach ($approvedPatients as $patient)
        <tr>
            <td>{{ $patient->patient_id }}</td>
            <td>{{ $patient->first_name }} {{ $patient->last_name }}</td>
            <!-- Form to update admission date/group for each patient -->
            <form action="{{ route('update-admission-date', $patient->patient_id) }}" method="POST">
                @csrf
                <td>
                    <select id="group_id" name="group_id" data-group-id="{{ $patient->group_id }}">                        
                        <option value="" disabled {{ $patient->group_id === null ? 'selected' : '' }}>Select Group</option>
                        @foreach ($groups as $group)
                            <option value="{{$group->group_id}}">{{$group->name}}</option>
                        @endforeach
                      </select>
                </td>
                <!-- Format admission_date to YYYY-MM-DD for date input compatibility -->
                <td>
                    <input type="date" name="admission_date" 
                        value="{{ $patient->admission_date ? \Carbon\Carbon::parse($patient->admission_date)->format('Y-m-d') : '' }}" 
                        required>
                </td>
                <td><button type="submit">Update Info</button></td>
            </form>
        </tr>
    @endforeach
</table>
@endsection
