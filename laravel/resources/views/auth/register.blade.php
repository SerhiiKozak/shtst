<!doctype html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <title>Register</title>
</head>
<body>
<h1>Реєстрація</h1>

@if ($errors->any())
    <div>
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form method="POST" action="{{ route('register') }}">
    @csrf

    <div>
        <label>Name</label>
        <input type="text" name="name" value="{{ old('name') }}" required>
    </div>

    <div>
        <label>Email</label>
        <input type="email" name="email" value="{{ old('email') }}" required>
    </div>

    <div>
        <label>Password</label>
        <input type="password" name="password" required>
    </div>

    <div>
        <label>Confirm password</label>
        <input type="password" name="password_confirmation" required>
    </div>

    <button type="submit">Register</button>
</form>

<p><a href="{{ route('login') }}">Login</a></p>
</body>
</html>
