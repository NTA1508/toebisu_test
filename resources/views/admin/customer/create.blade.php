<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tạo khách hàng</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center mb-4">Tạo khách hàng</h1>
        <form action="{{ route('admin.customer.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <!-- Registration ID -->
            <div class="mb-3">
                <label class="form-label" for="registration_id">ID Đăng ký (8 ký tự):</label>
                <input class="form-control" type="text" id="registration_id" name="registration_id" value="{{ old('registration_id') }}" required maxlength="8">
                @error('registration_id')
                    <p style="color: red;">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-3">
                <label class="form-label" for="name">Tên (không bắt buộc):</label>
                <input class="form-control" type="text" name="name" value="{{ old('name') }}">
                @error('name')
                    <p style="color: red;">{{ $message }}</p>
                @enderror
            </div>

            <!-- Email -->
            <div class="mb-3">
                <label class="form-label" for="email">Email:</label>
                <input class="form-control" type="email" name="email" value="{{ old('email') }}" required>
                @error('email')
                    <p style="color: red;">{{ $message }}</p>
                @enderror
            </div>

            <!-- Password -->
            <div class="mb-3">
                <label class="form-label" for="password">Mật khẩu:</label>
                <input class="form-control" type="password" name="password" required>
                @error('password')
                    <p style="color: red;">{{ $message }}</p>
                @enderror
            </div>

            <!-- Gender -->
            <div class="mb-3">
                <label class="form-label">Giới tính:</label>
                <label class="form-check-label"><input class="form-check-input" type="radio" name="gender" value="male" {{ old('gender') == 'male' ? 'checked' : '' }}> Nam</label>
                <label class="form-check-label"><input class="form-check-input" type="radio" name="gender" value="female" {{ old('gender') == 'female' ? 'checked' : '' }}> Nữ</label>
            </div>
            @error('gender')
                <p style="color: red;">{{ $message }}</p>
            @enderror

            <!-- Hobbies -->
            <div class="mb-3">
                <label class="form-label">Sở thích:</label>
                <div>
                    @foreach ($hobbies as $hobby)
                        <label>
                            <input class="form-check-input" type="checkbox" name="hobbies[]" value="{{ $hobby }}" {{ in_array($hobby, old('hobbies', [])) ? 'checked' : '' }}> {{ $hobby }}
                        </label>
                    @endforeach
                </div>
            </div>
            @error('hobbies')
                <p style="color: red;">{{ $message }}</p>
            @enderror

            <!-- Country -->
            <div class="mb-3">
                <label for="country" class="form-label">Quốc gia:</label>
                <select class="form-select" name="country" id="country">
                <option value="">Select a country</option>    
                    @foreach ($countries as $country)
                        <option value="{{ $country }}" {{ old('country') == $country ? 'selected' : '' }}>{{ $country }}</option>
                    @endforeach
                </select>
            </div>
            @error('country')
                <p style="color: red;">{{ $message }}</p>
            @enderror

            <!-- Profile Picture -->
            <div class="mb-3">
                <label class="form-label" for="profile_picture">Ảnh đại diện:</label>
                <input class="form-control" type="file" name="profile_picture" id="profile_picture">
            </div>
            @error('profile_picture')
                <p style="color: red;">{{ $message }}</p>
            @enderror

            <!-- Submit Button -->
            <button class="btn btn-primary" type="submit">Đăng ký</button>
        </form>
    </div>
</body>
</html>
