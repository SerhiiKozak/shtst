<!doctype html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
</head>
<body>
<h1>Увійти</h1>

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

<form method="POST" action="{{ route('login') }}">
    @csrf

    <div>
        <label>Email</label>
        <input type="email" name="email" value="{{ old('email') }}" required autofocus>
    </div>

    <div>
        <label>Password</label>
        <input type="password" name="password" required>
    </div>

    <div>
        <label>
            <input type="checkbox" name="remember">
            Запам'ятати мене
        </label>
    </div>

    <button type="submit">Login</button>
</form>

<p><a href="{{ route('register') }}">Реєстрація</a></p>
<p><a href="{{ route('password.request') }}">Забули пароль?</a></p>
</body>
</html>
