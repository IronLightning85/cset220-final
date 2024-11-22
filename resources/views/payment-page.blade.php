@extends('layout.outsidehometemplate')

@section('content')
<h2>Payment Page</h2>

<!-- Display status messages -->
@if (session('status'))
    <p style="color: green;">{{ session('status') }}</p>
@elseif (session('error'))
    <p style="color: red;">{{ session('error') }}</p>
@endif

<!-- Show total amount due -->
<p>Total Amount Due: ${{ number_format($patient->total_amount_due, 2) }}</p>

<!-- Payment form -->
<form action="{{ route('process-payment') }}" method="POST">
    @csrf
    <label for="payment_amount">Payment Amount:</label>
    <input type="number" name="payment_amount" id="payment_amount" 
           min="1" step="0.01" max="{{ $patient->total_amount_due }}" required>
    <button type="submit">Make Payment</button>
</form>
@endsection
