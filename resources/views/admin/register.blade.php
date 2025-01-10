<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng ký Admin</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            margin: 0 auto;
            max-width: 600px;
            padding: 20px;
            background-color: #f9f9f9;
        }

        h1 {
            text-align: center;
            color: #333;
        }

        form {
            background: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        label {
            display: block;
            margin-top: 15px;
            font-weight: bold;
            color: #555;
        }

        input[type="text"], input[type="email"], input[type="password"] {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        button {
            display: block;
            width: 100%;
            padding: 10px;
            margin-top: 20px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
        }

        button:hover {
            background-color: #45a049;
        }

        p {
            margin: 5px 0;
        }

        .success {
            color: green;
            font-weight: bold;
            text-align: center;
        }

        .error {
            color: red;
            font-size: 14px;
        }
    </style>
</head>
<body>
    <h1>Đăng ký Quản trị viên</h1>

    <!-- Success Message -->
    @if(session('success'))
        <p class="success">{{ session('success') }}</p>
    @endif

    <!-- Registration Form -->
    <form action="{{ route('admin.register') }}" method="POST">
        @csrf

        <!-- Registration ID -->
        <label for="registration_id">ID Đăng ký (8 ký tự):</label>
        <input type="text" id="registration_id" name="registration_id" value="{{ old('registration_id') }}" required maxlength="8">
        @error('registration_id')
            <p class="error">{{ $message }}</p>
        @enderror

        <!-- Name -->
        <label for="name">Tên (không bắt buộc):</label>
        <input type="text" id="name" name="name" value="{{ old('name') }}">
        @error('name')
            <p class="error">{{ $message }}</p>
        @enderror

        <!-- Email -->
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" value="{{ old('email') }}" required>
        @error('email')
            <p class="error">{{ $message }}</p>
        @enderror

        <!-- Password -->
        <label for="password">Mật khẩu:</label>
        <input type="password" id="password" name="password" required>
        @error('password')
            <p class="error">{{ $message }}</p>
        @enderror

        <!-- Password Confirmation -->
        <label for="password_confirmation">Xác nhận mật khẩu:</label>
        <input type="password" id="password_confirmation" name="password_confirmation" required>

        <!-- Submit Button -->
        <button type="submit">Đăng ký</button>
    </form>
</body>
</html>
