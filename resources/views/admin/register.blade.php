<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng ký Admin</title>
</head>
<body>
    <h1>Đăng ký Quản trị viên</h1>

    @if(session('success'))
        <p style="color: green;">{{ session('success') }}</p>
    @endif

    <form action="{{ route('admin.register') }}" method="POST">
        @csrf
        <label for="name">Tên (không bắt buộc):</label>
        <input type="text" id="name" name="name" value="{{ old('name') }}">
        @error('name')
            <p style="color: red;">{{ $message }}</p>
        @enderror

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" value="{{ old('email') }}" required>
        @error('email')
            <p style="color: red;">{{ $message }}</p>
        @enderror

        <label for="password">Mật khẩu:</label>
        <input type="password" id="password" name="password" required>
        @error('password')
            <p style="color: red;">{{ $message }}</p>
        @enderror

        <label for="password_confirmation">Xác nhận mật khẩu:</label>
        <input type="password" id="password_confirmation" name="password_confirmation" required>

        <button type="submit">Đăng ký</button>
    </form>
</body>
</html>
