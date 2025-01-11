@include('header')
<body>
    <div class="container mt-5">
        <h1 class="text-center mb-4">Customer Registration</h1>

        @if(session('success'))
            <p class="success text-success">{{ session('success') }}</p>
        @endif

        <form action="{{ route('customer.register') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <!-- Registration ID -->
            <div class="mb-3">
                <label class="form-label" for="registration_id">ID Đăng ký (8 ký tự):</label>
                <input class="form-control"  type="text" id="registration_id" name="registration_id" value="{{ old('registration_id') }}" required maxlength="8">
                @error('registration_id')
                    <p class="text-danger">{{ $message }}</p>
                @enderror
            </div>

            <!-- Name -->
            <div class="mb-3">
                <label class="form-label" for="name">Tên (không bắt buộc):</label>
                <input class="form-control" type="text" name="name" value="{{ old('name') }}">
                @error('name')
                    <p class="text-danger">{{ $message }}</p>
                @enderror
            </div>

            <!-- Email -->
            <div class="mb-3">
                <label class="form-label" for="email">Email:</label>
                <input class="form-control" type="email" name="email" value="{{ old('email') }}" required>
                @error('email')
                    <p class="text-danger">{{ $message }}</p>
                @enderror
            </div>

            <!-- Password -->
            <div class="mb-3">
                <label class="form-label" for="password">Mật khẩu:</label>
                <input class="form-control" type="password" name="password" required>
                @error('password')
                    <p class="text-danger">{{ $message }}</p>
                @enderror
            </div>

            <!-- Gender -->
            <div class="mb-3">
                <label class="form-label">Giới tính:</label>
                <label class="form-check-label"><input class="form-check-input" type="radio" name="gender" value="male" {{ old('gender') == 'male' ? 'checked' : '' }}> Nam</label>
                <label class="form-check-label"><input class="form-check-input" type="radio" name="gender" value="female" {{ old('gender') == 'female' ? 'checked' : '' }}> Nữ</label>
            </div>
            @error('gender')
                <p class="text-danger">{{ $message }}</p>
            @enderror

            <!-- Hobbies -->
            <div class="mb-3">
                <label class="form-label">Sở thích:</label>
                <div>
                    @foreach ($hobbies as $hobby)
                        <label>
                            <input type="checkbox" name="hobbies[]" value="{{ $hobby }}" {{ in_array($hobby, old('hobbies', [])) ? 'checked' : '' }}> {{ $hobby }}
                        </label>
                    @endforeach
                </div>
            </div>
            @error('hobbies')
                <p class="text-danger">{{ $message }}</p>
            @enderror

            <!-- Country -->
            <div class="mb-3">
                <label class="form-label" for="country">Quốc gia:</label>
                <select class="form-select" name="country" id="country">
                <option value="">Select a country</option>    
                    @foreach ($countries as $country)
                        <option value="{{ $country }}" {{ old('country') == $country ? 'selected' : '' }}>{{ $country }}</option>
                    @endforeach
                </select>
            </div>
            @error('country')
                <p class="text-danger">{{ $message }}</p>
            @enderror

            <!-- Profile Picture -->
            <div class="mb-3">
                <label class="form-label" for="profile_picture">Ảnh đại diện:</label>
                <input class="form-control" type="file" name="profile_picture" id="profile_picture">
            </div>
            @error('profile_picture')
                <p class="text-danger">{{ $message }}</p>
            @enderror

            <!-- Submit Button -->
            <button class="btn btn-primary" type="submit">Đăng ký</button>
        </form>
    </div>
</body>
@include('footer')
</html>
