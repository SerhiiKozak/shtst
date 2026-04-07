<!doctype html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <title>Reset password</title>
</head>
<body>
<h1>Скидання пароля</h1>

@if ($errors->any())
    <div>
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form method="POST" action="{{ route('password.update') }}">
    @csrf

    <input type="hidden" name="token" value="{{ $request->route('token') }}">

    <div>
        <label>Email</label>
        <input type="email" name="email" value="{{ old('email', $request->email) }}" required>
    </div>

    <div>
        <label>New password</label>
        <input type="password" name="password" required>
    </div>

    <div>
        <label>Confirm password</label>
        <input type="password" name="password_confirmation" required>
    </div>

    <button type="submit">Зберегти пароль</button>
</form>
</body>
</html>
