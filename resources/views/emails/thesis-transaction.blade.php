<!DOCTYPE html>
<html>
<head>
    <title>Thesis Transaction Notification</title>
</head>
<body>
    <h2>Hello {{ $recipient['name'] }},</h2>
    
    <p>A new thesis transaction has been processed with the following details:</p>
    
    <ul>
        <li>Tracking Number: {{ $transaction->tracking_number }}</li>
        <li>Student: {{ $transaction->student->first_name }} {{ $transaction->student->last_name }}</li>
        <li>Defense Date: {{ $transaction->defense_date }}</li>
        <li>Defense Time: {{ $transaction->defense_time }}</li>
        <li>Your Role: {{ $recipient['role'] }}</li>
        @if(Auth::user()->usertype->name === 'Cashiers')
        <li>Net Amount: {{ $transaction->net_amount }}</li>
        <li>Deduction: {{ $transaction->deduction }}</li>
        @endif
    </ul>

    <p>Please review the details and take necessary action.</p>

    <p>Best regards,<br>
    Thesis Administration Team</p>
</body>
</html> 