@include('header')
<body>
    <div class="container mt-5">
        <h1 class="text-center mb-4">会員登録</h1>

        @if(session('success'))
            <p class="success text-success">{{ session('success') }}</p>
        @endif

        <form action="{{ route('customer.register') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <!-- Registration ID -->
            <div class="mb-3">
                <label class="form-label" for="registration_id">ID:</label>
                <input class="form-control"  type="text" id="registration_id" name="registration_id" value="{{ old('registration_id') }}" required maxlength="8">
                @error('registration_id')
                    <p class="text-danger">{{ $message }}</p>
                @enderror
            </div>

            <!-- Name -->
            <div class="mb-3">
                <label class="form-label" for="name">名前:</label>
                <input class="form-control" type="text" name="name" value="{{ old('name') }}">
                @error('name')
                    <p class="text-danger">{{ $message }}</p>
                @enderror
            </div>

            <!-- Email -->
            <div class="mb-3">
                <label class="form-label" for="email">メール:</label>
                <input class="form-control" type="email" name="email" value="{{ old('email') }}" required>
                @error('email')
                    <p class="text-danger">{{ $message }}</p>
                @enderror
            </div>

            <!-- Password -->
            <div class="mb-3">
                <label class="form-label" for="password">パスワード：</label>
                <input class="form-control" type="password" name="password" required>
                @error('password')
                    <p class="text-danger">{{ $message }}</p>
                @enderror
            </div>

            <!-- Gender -->
            <div class="mb-3">
                <label class="form-label">性別:</label>
                <label class="form-check-label"><input class="form-check-input" type="radio" name="gender" value="男" {{ old('gender') == '男' ? 'checked' : '' }}>男</label>
                <label class="form-check-label"><input class="form-check-input" type="radio" name="gender" value="女" {{ old('gender') == '女' ? 'checked' : '' }}> 女</label>
            </div>
            @error('gender')
                <p class="text-danger">{{ $message }}</p>
            @enderror

            <!-- Hobbies -->
            <div class="mb-3">
                <label class="form-label">趣味:</label>
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
                <label class="form-label" for="country">国:</label>
                <select class="form-select" name="country" id="country">
                <option value="">国を選択してください</option>    
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
                <label class="form-label" for="profile_picture">プロフィール画像:</label>
                <input class="form-control" type="file" name="profile_picture" id="profile_picture">
            </div>
            @error('profile_picture')
                <p class="text-danger">{{ $message }}</p>
            @enderror

            <!-- Submit Button -->
            <button class="btn btn-primary" type="submit">登録</button>
        </form>
    </div>
</body>
@include('footer')
</html>
