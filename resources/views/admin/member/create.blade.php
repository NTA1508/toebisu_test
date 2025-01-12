@include('header')
<body>
    <div class="container mt-5">
    <h1 class="text-center mb-4">管理者登録</h1>
        <form action="{{ route('admin.member.store') }}" method="POST">
            @csrf
            
            <div class="mb-3">
                <label class="form-label" for="registration_id">ID:</label>
                <input class="form-control"  type="text" id="registration_id" name="registration_id" value="{{ old('registration_id') }}" required maxlength="8">
                @error('registration_id')
                    <p class="text-danger">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-3">
                <label class="form-label" for="name">名前:</label>
                <input class="form-control"  type="text" name="name" value="{{ old('name') }}">
                @error('name')
                    <p class="text-danger">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-3">
                <label class="form-label" for="email">メール:</label>
                <input class="form-control"  type="email" name="email" value="{{ old('email') }}" required>
                @error('email')
                    <p class="text-danger">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-3">
                <label class="form-label" for="password">パスワード：</label>
                <input class="form-control"  type="password" name="password" required>
                @error('password')
                    <p class="text-danger">{{ $message }}</p>
                @enderror
            </div>

            <button class="btn btn-primary" type="submit">管理者登録</button>
        </form>
    </div>
</body>
@include('footer')
</html>
