<!doctype html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <title>Verify email</title>
</head>
<body>
<h1>Підтвердження email</h1>

@if (session('status') == 'verification-link-sent')
    <div>Новий лист підтвердження надіслано.</div>
@endif

<p>Перевір пошту і підтвердь email.</p>

<form method="POST" action="{{ route('verification.send') }}">
    @csrf
    <button type="submit">Надіслати лист ще раз</button>
</form>

<form method="POST" action="{{ route('logout') }}">
    @csrf
    <button type="submit">Logout</button>
</form>
</body>
</html>
