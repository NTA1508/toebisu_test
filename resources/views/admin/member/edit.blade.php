<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chỉnh sửa quản trị viên</title>
</head>
<body>
    <h1>Chỉnh sửa quản trị viên</h1>
    <form action="{{ route('admin.member.update', $admin->id) }}" method="POST">
        @csrf

        <label for="registration_id">ID:</label>
        <input type="text" id="registration_id" name="registration_id" value="{{ old('registration_id', $admin->registration_id) }}"  required maxlength="8">
        @error('registration_id')
            <p style="color: red;">{{ $message }}</p>
        @enderror

        <label for="name">Tên (không bắt buộc):</label>
        <input type="text" name="name" value="{{ old('name', $admin->name) }}">
        @error('name')
            <p style="color: red;">{{ $message }}</p>
        @enderror

        <label for="email">Email:</label>
        <input type="email" name="email" value="{{ old('email', $admin->email) }}" required>
        @error('email')
            <p style="color: red;">{{ $message }}</p>
        @enderror

        <label for="password">Mật khẩu (để trống nếu không thay đổi):</label>
        <input type="password" name="password">
        @error('password')
            <p style="color: red;">{{ $message }}</p>
        @enderror

        <button type="submit">Cập nhật</button>
    </form>
</body>
</html>
