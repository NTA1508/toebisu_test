@include('header')
<body>
    <h1>Customer Registration</h1>

    @if ($errors->any())
        <div class="text-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('customer.register') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <!-- Registration ID -->
        <label for="registration_id">ID Đăng ký (8 ký tự):</label>
        <input type="text" id="registration_id" name="registration_id" value="{{ old('registration_id') }}" required maxlength="8">
        @error('registration_id')
            <p class="text-danger">{{ $message }}</p>
        @enderror

        <!-- Name -->
        <label for="name">Tên (không bắt buộc):</label>
        <input type="text" name="name" value="{{ old('name') }}">
        @error('name')
            <p class="text-danger">{{ $message }}</p>
        @enderror

        <!-- Email -->
        <label for="email">Email:</label>
        <input type="email" name="email" value="{{ old('email') }}" required>
        @error('email')
            <p class="text-danger">{{ $message }}</p>
        @enderror

        <!-- Password -->
        <label for="password">Mật khẩu:</label>
        <input type="password" name="password" required>
        @error('password')
            <p class="text-danger">{{ $message }}</p>
        @enderror

        <!-- Gender -->
        <div>
            <label>Giới tính:</label>
            <label><input type="radio" name="gender" value="male" {{ old('gender') == 'male' ? 'checked' : '' }}> Nam</label>
            <label><input type="radio" name="gender" value="female" {{ old('gender') == 'female' ? 'checked' : '' }}> Nữ</label>
        </div>
        @error('gender')
            <p class="text-danger">{{ $message }}</p>
        @enderror

        <!-- Hobbies -->
        <div>
            <label>Sở thích:</label>
            @foreach ($hobbies as $hobby)
                <label>
                    <input type="checkbox" name="hobbies[]" value="{{ $hobby }}" {{ in_array($hobby, old('hobbies', [])) ? 'checked' : '' }}> {{ $hobby }}
                </label>
            @endforeach
        </div>
        @error('hobbies')
            <p class="text-danger">{{ $message }}</p>
        @enderror

        <!-- Country -->
        <div>
            <label for="country">Quốc gia:</label>
            <select name="country" id="country">
                @foreach ($countries as $country)
                    <option value="{{ $country }}" {{ old('country') == $country ? 'selected' : '' }}>{{ $country }}</option>
                @endforeach
            </select>
        </div>
        @error('country')
            <p class="text-danger">{{ $message }}</p>
        @enderror

        <!-- Profile Picture -->
        <div>
            <label for="profile_picture">Ảnh đại diện:</label>
            <input type="file" name="profile_picture" id="profile_picture">
        </div>
        @error('profile_picture')
            <p style="color: red;">{{ $message }}</p>
        @enderror

        <!-- Submit Button -->
        <button type="submit">Đăng ký</button>
    </form>
</body>
@include('footer')
</html>
