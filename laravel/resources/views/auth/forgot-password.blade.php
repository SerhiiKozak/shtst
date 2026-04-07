<!doctype html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <title>Forgot password</title>
</head>
<body>
<h1>Відновлення пароля</h1>

@if (session('status'))
    <div>{{ session('status') }}</div>
@endif

@if ($errors->any())
    <div>
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form method="POST" action="{{ route('password.email') }}">
    @csrf

    <div>
        <label>Email</label>
        <input type="email" name="email" value="{{ old('email') }}" required>
    </div>

    <button type="submit">Надіслати лист для скидання</button>
</form>
</body>
</html>
