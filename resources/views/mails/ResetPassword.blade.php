<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h2>Reset Password</h2>
    <p>Halo, {{ $username->name }}</p>
    <p>Kode OTP untuk reset password Anda adalah:</p>
    <h3>{{ $otp }}</h3>
    <p>Kode ini berlaku selama 10 menit.</p>
</body>

</html>