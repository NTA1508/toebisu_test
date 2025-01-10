<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tạo quản trị viên</title>
</head>
<body>
    <h1>Tạo quản trị viên</h1>
    <form action="{{ route('admin.member.store') }}" method="POST">
        @csrf
        
        <label for="registration_id">ID Đăng ký (8 ký tự):</label>
        <input type="text" id="registration_id" name="registration_id" value="{{ old('registration_id') }}" required maxlength="8">
        @error('registration_id')
            <p style="color: red;">{{ $message }}</p>
        @enderror

        <label for="name">Tên (không bắt buộc):</label>
        <input type="text" name="name" value="{{ old('name') }}">
        @error('name')
            <p style="color: red;">{{ $message }}</p>
        @enderror

        <label for="email">Email:</label>
        <input type="email" name="email" value="{{ old('email') }}" required>
        @error('email')
            <p style="color: red;">{{ $message }}</p>
        @enderror

        <label for="password">Mật khẩu:</label>
        <input type="password" name="password" required>
        @error('password')
            <p style="color: red;">{{ $message }}</p>
        @enderror

        <button type="submit">Tạo mới</button>
    </form>
</body>
</html>
