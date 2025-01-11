@include('header')
<body>
    <div class="container mt-5">
        <h1 class="text-center mb-4">Edit customer</h1>
        <form action="{{ route('admin.customer.update', $customer->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            
            <div class="mb-3">
                <label class="form-label" for="registration_id">ID:</label>
                <input class="form-control" type="text" id="registration_id" name="registration_id" value="{{ old('registration_id', $customer->registration_id) }}"  required maxlength="8">
                @error('registration_id')
                    <p style="color: red;">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-3">
                <label class="form-label"  for="name">Tên khách hàng:</label>
                <input class="form-control" type="text" name="name" id="name" value="{{ old('name', $customer->name) }}">
                @error('name')
                    <p style="color: red;">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-3">
                <label class="form-label"  for="email">Email:</label>
                <input class="form-control" type="email" name="email" value="{{ old('email', $customer->email) }}" required>
                @error('email')
                    <p style="color: red;">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-3">
                <label class="form-label" >Giới tính:</label>
                <label class="form-label" ><input class="form-check-input" type="radio" name="gender" value="male" {{ $customer->gender == 'male' ? 'checked' : '' }}> Nam</label>
                <label class="form-label" ><input class="form-check-input" type="radio" name="gender" value="female" {{ $customer->gender == 'female' ? 'checked' : '' }}> Nữ</label>
                @error('gender')
                    <p style="color: red;">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-3">
                <label class="form-label" >Sở thích:</label>
                <div>
                    @foreach ($hobbies as $hobby)
                        <label class="form-label" >
                            <input class="form-check-input" type="checkbox" name="hobbies[]" value="{{ $hobby }}" {{ in_array($hobby, $selectedHobbies) ? 'checked' : '' }}> {{ $hobby }}
                        </label class="form-label" >
                    @endforeach
                    @error('hobbies')
                        <p style="color: red;">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="mb-3">
                <label for="country">Quốc gia:</label>
                <select class="form-select" name="country" id="country">
                    @foreach ($countries as $country)
                        <option value="{{ $country }}" {{ $customer->country == $country ? 'selected' : '' }}>{{ $country }}</option>
                    @endforeach
                </select>
                @error('country')
                    <p style="color: red;">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-3">
            <label for="password">Mật khẩu (để trống nếu không thay đổi):</label>
            <input class="form-control" type="password" name="password">
            @error('password')
                <p style="color: red;">{{ $message }}</p>
            @enderror

            </div>

            <div class="mb-3">
                <label for="profile_picture">Ảnh đại diện:</label>
                @if ($customer->profile_picture)
                    <img src="{{ asset('storage/' . $customer->profile_picture) }}" alt="Profile Picture" width="100">
                @endif
                <input class="form-control"  type="file" name="profile_picture" id="profile_picture">
                @error('profile_picture')
                    <p style="color: red;">{{ $message }}</p>
                @enderror
            </div>

            <button class="btn btn-primary" type="submit">Cập nhật</button>
        </form>
    </div>
</body>
@include('footer')
</html>
