<!DOCTYPE html>
<html>

<head>
    <title>Verification Code</title>
</head>

<body>
    <h1>Hello, {{ $name }}!</h1>
    <p>Please use the following code to reset your password:</p>
    <h2>{{ $verificationCode }}</h2>
    <p>The code is valid for 5 minutes. If you didn't wan't to reset your password, please ignore this email.</p>
</body>

</html>