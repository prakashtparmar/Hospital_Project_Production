<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>{{ $title ?? 'Notification' }}</title>
</head>
<body style="font-family: Arial, Helvetica, sans-serif; background:#f6f6f6; padding:20px;">

    <div style="max-width:600px;margin:0 auto;background:#ffffff;padding:20px;border-radius:6px;">

        <h2 style="color:#2c3e50;">
            {{ $title ?? 'Notification' }}
        </h2>

        <hr>

        <p style="font-size:15px; color:#333;">
            {!! nl2br(e($content ?? '')) !!}
        </p>

        <hr>

        <p style="font-size:13px;color:#777;">
            Regards,<br>
            {{ config('app.name') }}
        </p>

    </div>

</body>
</html>
