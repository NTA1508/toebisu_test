@include('header')
<body>
    <div class="container mt-5">
        <h1 class="text-center mb-4">会員ログイン</h1>

        @if ($errors->any())
            <div>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li class="text-danger">{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if(session('success'))
            <p class="success text-success">{{ session('success') }}</p>
        @endif

        <form action="{{ route('customer.login') }}" method="POST">
            @csrf

            <div class="mb-3">
                <label class="form-label" for="registration_id">ID:</label>
                <input class="form-control" type="registration_id" id="registration_id" name="registration_id" value="{{ old('registration_id') }}" required>
            </div>

            <div class="mb-3">
                <label class="form-label" for="password">パスワード:</label>
                <input class="form-control" type="password" id="password" name="password" required>
            </div>

            <div class="mb-3">
                <label class="form-label">
                    <input class="form-check-input" type="checkbox" name="remember"> ログイン状態を保持
                </label>
            </div>
            <div class="mb-3">
                <p> アカウントをお持ちでないですか？ <a href="/entry">今すぐ登録</a></p>
            </div>
            <button class="btn btn-primary" type="submit">ログイン</button>
        </form>
    </div>
</body>
@include('footer')
</html>
