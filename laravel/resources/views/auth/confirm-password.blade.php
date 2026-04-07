<!doctype html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <title>Confirm password</title>
</head>
<body>
<h1>Підтвердження пароля</h1>

@if ($errors->any())
    <div>
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form method="POST" action="{{ route('password.confirm') }}">
    @csrf

    <div>
        <label>Password</label>
        <input type="password" name="password" required>
    </div>

    <button type="submit">Підтвердити</button>
</form>
</body>
</html>
