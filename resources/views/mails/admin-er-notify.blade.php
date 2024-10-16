<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Expiry Reminder Email</title>
</head>

<body>
    <p>Dear Sir,</p>

    <p>A {{ $mailData['email_for'] }} <strong>{{ $mailData['name'] }}</strong> will expire in
        {{ $mailData['day'] }} days. Client name: {{ $mailData['client'] }}. Client email: {{ $mailData['email'] }}</p>
</body>

</html>
