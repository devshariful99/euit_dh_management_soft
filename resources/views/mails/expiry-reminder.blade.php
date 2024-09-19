<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Expiry Reminder Email</title>
</head>

<body>
    <p>Dear {{ $mailData['client'] }},</p>

    <p>Your {{ $mailData['email_for'] }} <strong>{{ $mailData['name'] }}</strong> is set to expire in
        {{ $mailData['day'] }} days.</p>

    <p>Please make sure to renew it before the expiration date to avoid any disruptions in your service.</p>
    <p>Thank you for using our services!</p>
</body>

</html>
