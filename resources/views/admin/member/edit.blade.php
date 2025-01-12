@include('header')
<body>
    <div class="container mt-5">
        <h1 class="text-center mb-4">管理者編集</h1>
        <form action="{{ route('admin.member.update', $admin->id) }}" method="POST">
            @csrf

            <div class="mb-3">
                <label class="form-label" for="registration_id">ID:</label>
                <input class="form-control" type="text" id="registration_id" name="registration_id" value="{{ old('registration_id', $admin->registration_id) }}"  required maxlength="8">
                @error('registration_id')
                    <p style="color: red;">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-3">
                <label class="form-label" for="name">名前:</label>
                <input class="form-control" type="text" name="name" value="{{ old('name', $admin->name) }}">
                @error('name')
                    <p style="color: red;">{{ $message }}</p>
                @enderror
            </div> 

            <div class="mb-3">
                <label class="form-label" for="email">メール:</label>
                <input class="form-control" type="email" name="email" value="{{ old('email', $admin->email) }}" required>
                @error('email')
                    <p style="color: red;">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-3">
                <label class="form-label" for="password">パスワード（変更しない場合は空白のままにしてください:</label>
                <input class="form-control" type="password" name="password">
                @error('password')
                    <p style="color: red;">{{ $message }}</p>
                @enderror
            </div>

            <button class="btn btn-primary" type="submit">管理者編集</button>
        </form>
    </div>
</body>
@include('footer')
</html>
