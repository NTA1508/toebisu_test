<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
</head>
<body>
    <h1>Đăng nhập Admin</h1>

    @if ($errors->any())
        <div>
            <ul>
                @foreach ($errors->all() as $error)
                    <li style="color: red;">{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.login') }}" method="POST">
        @csrf
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" value="{{ old('email') }}" required>

        <label for="password">Mật khẩu:</label>
        <input type="password" id="password" name="password" required>

        <label>
            <input type="checkbox" name="remember"> Ghi nhớ đăng nhập
        </label>

        <button type="submit">Đăng nhập</button>
    </form>
</body>
</html>
