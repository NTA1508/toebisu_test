<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
</head>
<body>
    <h1>Đăng nhập Customer</h1>

    @if ($errors->any())
        <div>
            <ul>
                @foreach ($errors->all() as $error)
                    <li style="color: red;">{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('customer.login') }}" method="POST">
        @csrf
        <label for="registration_id">ID:</label>
        <input type="registration_id" id="registration_id" name="registration_id" value="{{ old('registration_id') }}" required>

        <label for="password">Mật khẩu:</label>
        <input type="password" id="password" name="password" required>

        <label>
            <input type="checkbox" name="remember"> Ghi nhớ đăng nhập
        </label>

        <button type="submit">Đăng nhập</button>
    </form>
</body>
</html>
