@include('header')
<body>
    <div class="container mt-5">
        <h1 class="text-center mb-4">Đăng nhập Admin</h1>

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

        <form action="{{ route('admin.login') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label class="form-label" for="registration_id">ID:</label>
                <input class="form-control" type="registration_id" id="registration_id" name="registration_id" value="{{ old('registration_id') }}" required>
            </div>
            <div class="mb-3">
                <label class="form-label" for="password">Mật khẩu:</label>
                <input class="form-control" type="password" id="password" name="password" required>
            </div>

            <div class="mb-3">
                <label>
                    <input class="form-check-input" type="checkbox" name="remember"> Ghi nhớ đăng nhập
                </label>
            </div>
            <div class="mb-3">
               <p> Don't have an account? <a href="/admin/register">Register now</a></p>
            </div>
            <button class="btn btn-primary" type="submit">Đăng nhập</button>
        </form>
    </div>
</body>
@include('footer')
</html>
