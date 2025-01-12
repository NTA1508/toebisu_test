@include('header')
<body>
    <div class="container mt-5">
        <h1 class="text-center mb-4">管理者登録</h1>

        <!-- Success Message -->
        @if(session('success'))
            <p class="success text-success">{{ session('success') }}</p>
        @endif

        <!-- Registration Form -->
        <form action="{{ route('admin.register') }}" method="POST">
            @csrf

            <!-- Registration ID -->
            <div class="mb-3">
                <label class="form-label" for="registration_id">ID:</label>
                <input class="form-control" type="text" id="registration_id" name="registration_id" value="{{ old('registration_id') }}" required maxlength="8">
                @error('registration_id')
                    <p class="error text-danger">{{ $message }}</p>
                @enderror
            </div>

            <!-- Name -->
            <div class="mb-3">
                <label class="form-label" for="name">名前:</label>
                <input class="form-control" type="text" id="name" name="name" value="{{ old('name') }}">
                @error('name')
                    <p class="error text-danger">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-3">
                <!-- Email -->
                <label class="form-label" for="email">メール:</label>
                <input class="form-control" type="email" id="email" name="email" value="{{ old('email') }}" required>
                @error('email')
                    <p class="error text-danger">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-3">
                <!-- Password -->
                <label class="form-label" for="password">パスワード：</label>
                <input class="form-control" type="password" id="password" name="password" required>
                @error('password')
                    <p class="error text-danger">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-3">
                <!-- Password Confirmation -->
                <label class="form-label" for="password_confirmation">パスワードの確認:</label>
                <input class="form-control" type="password" id="password_confirmation" name="password_confirmation" required>
            </div>
            <!-- Submit Button -->
            <button class="btn btn-primary" type="submit">登録</button>
        </form>
    </div>
</body>
@include('footer')
</html>
