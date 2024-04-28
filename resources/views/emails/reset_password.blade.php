<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
</head>
<body>
    <h2>Hello,</h2>
    <p>Here's your password reset PIN code: <strong>{{ $pin }}</strong></p>
    <p>Click <a href="{{ route('password.reset', ['token' => $token]) }}">here</a> to reset your password.</p>
</body>
</html>
