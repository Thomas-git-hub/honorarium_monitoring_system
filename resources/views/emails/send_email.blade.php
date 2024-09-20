<!DOCTYPE html>
<html>
<head>
    <title>{{ $emailData['subject'] }}</title>
</head>
<body>
    <div style="border: 1px solid #ddd; padding: 10px; border-radius: 5px; max-width: 600px; margin: auto;">
        <p><strong>Message:</strong></p>
        <p>{{ $emailData['message'] }}</p>
        <p><strong>Sent to:</strong> {{ $emailData['employee_fname'] }}</p>

        <p><strong>Missing Documents:</strong></p>
        <ul>
            @foreach($emailData['documents'] as $document)
                <li>{{ $document }}</li>
            @endforeach
        </ul>
    </div>
</body>
</html>


