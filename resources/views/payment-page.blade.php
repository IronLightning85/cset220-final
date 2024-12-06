@extends('layout.outsidehometemplate')

@section('content')
<h1>Payment Page</h1>

<center>
    <div class="content-containr" style="display: block">
        <div class="model-section">
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
        </div>
    </div>
</center>

@endsection
