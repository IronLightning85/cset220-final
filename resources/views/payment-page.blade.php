<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Page</title>
</head>
<body>
    <h2>Payment Page</h2>

    <!-- Display status messages -->
    @if (session('status'))
        <p>{{ session('status') }}</p>
    @elseif (session('error'))
        <p>{{ session('error') }}</p>
    @endif

    <!-- Show total amount due -->
    <p>Total Amount Due: ${{ number_format($patient->total_amount_due, 2) }}</p>

    <!-- Payment form -->
    <form action="{{ route('process-payment') }}" method="POST">
        @csrf
        <label for="payment_amount">Payment Amount:</label>
        <input type="number" name="payment_amount" id="payment_amount" min="1" step="0.01" required>
        <button type="submit">Make Payment</button>
    </form>
</body>
</html>
