<!DOCTYPE html>
<html>
<body style="font-family: Arial, sans-serif;">
    <h2>Halo, {{ $name }}! 🎀</h2>
    <p>Terima kasih sudah mendaftar di <b>B’cake</b> 💗</p>
    <p>Ini kode OTP verifikasi akunmu:</p>

    <h1 style="font-size: 32px; letter-spacing: 6px; margin: 16px 0;">
        {{ $otp }}
    </h1>

    <p>Kode ini berlaku selama <b>5 menit</b>. Jangan berikan ke orang lain ya 🍰</p>
</body>
</html>
