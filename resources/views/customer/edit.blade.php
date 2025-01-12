@include('header')
<body>
    <div class="container mt-5">
        <h1 class="text-center mb-4">プロフィール編集</h1>
        <form action="{{ route('mypage.update') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <!-- Id -->
            <div class="mb-3">
            <label for="registration_id">ID:</label>
                <input type="text" class="form-control" id="registration_id" name="registration_id" value="{{ old('registration_id', $customer->registration_id) }}"  required maxlength="8">
                @error('registration_id')
                    <p class="text-danger">{{ $message }}</p>
                @enderror
            </div>

            <!-- Name -->
            <div class="mb-3">
                <label for="name" class="form-label">名前:</label>
                <input type="text" class="form-control" id="name" name="name" 
                    value="{{ old('name', $customer->name) }}" placeholder="Enter your name">
                @error('name')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <!-- Email -->
            <div class="mb-3">
                <label for="email" class="form-label">メール:</label>
                <input type="email" class="form-control" id="email" name="email" 
                    value="{{ old('email', $customer->email) }}" placeholder="Enter your email">
                @error('email')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <!-- Country Dropdown -->
            <div class="mb-3">
                <label for="country" class="form-label">国:</label>
                <select class="form-select" id="country" name="country">
                    @foreach ($countries as $country)
                        <option value="{{ $country }}" {{ $customer->country == $country ? 'selected' : '' }}>
                            {{ $country }}
                        </option>
                    @endforeach
                </select>
                @error('country')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <div class="mb-3">
                <label for="password">パスワード（変更しない場合は空白のままにしてください:</label>
                <input type="password" class="form-control" name="password">
                @error('password')
                    <p class="text-danger">{{ $message }}</p>
                @enderror
            </div>

            <!-- Gender Radio -->
            <div class="mb-3">
                <label class="form-label">性別:</label>
                <div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="gender" id="男" value="男" 
                            {{ $customer->gender == '男' ? 'checked' : '' }}>
                        <label class="form-check-label" for="男">男</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="gender" id="女" value="女" 
                            {{ $customer->gender == '女' ? 'checked' : '' }}>
                        <label class="form-check-label" for="女">女</label>
                    </div>
                </div>
                @error('gender')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <!-- Hobbies Checkboxes -->
            <div class="mb-3">
                <label class="form-label">趣味:</label>
                <div>
                    @foreach ($hobbies as $hobby)
                            <input class="form-check-input" type="checkbox" name="hobbies[]" id="hobby_{{ $hobby }}" 
                                value="{{ $hobby }}" {{ in_array($hobby, $selectedHobbies) ? 'checked' : '' }}>
                            <label class="form-check-label" for="hobby_{{ $hobby }}">{{ $hobby }}</label>
                    @endforeach
                </div>
                @error('hobbies')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <!-- Profile Picture -->
            <div class="mb-3">
                <label for="profile_picture" class="form-label">プロフィール画像:</label>
                <input type="file" class="form-control" id="profile_picture" name="profile_picture">
                @if ($customer->profile_picture)
                    <img src="{{ asset('storage/' . $customer->profile_picture) }}" alt="Profile Picture" 
                        class="img-thumbnail mt-2" style="width: 150px;">
                @endif
                @error('profile_picture')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <!-- Submit Button -->
            <button type="submit" class="btn btn-primary">Update</button>
        </form>
    </div>

    <!-- Link Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
@include('footer')
</html>
