@extends('layout.outsidehometemplate')

@section('content')
@if($level === 1)
<div class="container">
    <h1>Patient Payments</h1>

    <form action="{{ route('payments-update') }}" method="POST">
        @csrf
        <table class="table">
            <thead>
                <tr>
                    <th>Patient ID</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Total Due</th>
                    <th>New Payment</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($patients as $patient)
                <tr>
                    <td>{{ $patient->patient_id }}</td>
                    <td>{{ $patient->first_name }}</td>
                    <td>{{ $patient->last_name }}</td>
                    <td>${{ number_format($patient->total_amount_due, 2) }}</td>
                    <td>
                        <input type="number" step="0.01" min="0" name="payments[{{ $patient->patient_id }}]" class="form-control">
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <button type="submit" class="btn btn-success">Ok</button>
    </form>
    <button onclick="location.href='{{ url('home') }}'">Cancel</button>
    <form action="{{ route('apply-charges') }}" method="POST">
        @csrf
        <button type="submit" class="btn btn-warning">Apply Daily Charges</button>
    </form>
    <br><br><br>
</div>
@else
    <h1>Whoops! Looks like you don't have access.</h1>
<br><br><br>
<center><img src="css/not loggged in.gif" alt=""></center>
@endif

@endsection
