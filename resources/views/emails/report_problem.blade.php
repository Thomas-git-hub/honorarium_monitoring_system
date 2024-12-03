<!DOCTYPE html>
<html>
<head>
    <title> {{ $emailData['subject'] }}</title>
</head>
<body>
    <h1>Problem Reported</h1>
    <p><strong>From:</strong> {{ $emailData['first_name'] }} {{ $emailData['last_name'] }}</p>
    <p><strong>Message:</strong></p>
    <p>{{ $emailData['message'] }}</p>
    <p><strong>Reported At:</strong> {{ $emailData['reportedAt'] }}</p>
</body>
</html> 