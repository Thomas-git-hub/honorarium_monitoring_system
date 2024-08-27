<html>
<head>
    <title>Transaction Status Update</title>
</head>
<body>
    <h1>Transaction Status Update</h1>
    <p>Dear {{ $emailData['employee_fname'] }},</p>
    <p>Your transaction with ID {{ $emailData['transaction_id'] }} has been updated to <strong>{{ $emailData['status'] }}</strong>.</p>
    <p>Thank you.</p>
</body>
</html>
