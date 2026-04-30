<!DOCTYPE html>
<html>
<body>

<p>Hello {{ $user->first_name ?? $user->last_name }},</p>

<p>Your password has been reset successfully.</p>

<p><strong>Your new login password is:</strong></p>

<h2>{{ $newPassword }}</h2>

<p>Please log in and change it immediately for security.</p>

<br>
<p>Regards,<br>Support Team</p>

</body>
</html>
