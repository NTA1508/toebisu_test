@include('header')
<body>
    <div class="container mt-5">
        <h1 class="text-center mb-4">会員編集</h1>
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
                <label class="form-label"  for="name">名前:</label>
                <input class="form-control" type="text" name="name" id="name" value="{{ old('name', $customer->name) }}">
                @error('name')
                    <p style="color: red;">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-3">
                <label class="form-label"  for="email">メール:</label>
                <input class="form-control" type="email" name="email" value="{{ old('email', $customer->email) }}" required>
                @error('email')
                    <p style="color: red;">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-3">
                <label class="form-label" >性別:</label>
                <label class="form-label" ><input class="form-check-input" type="radio" name="gender" value="男" {{ $customer->gender == '男' ? 'checked' : '' }}> 男</label>
                <label class="form-label" ><input class="form-check-input" type="radio" name="gender" value="女" {{ $customer->gender == '女' ? 'checked' : '' }}> 女</label>
                @error('gender')
                    <p style="color: red;">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-3">
                <label class="form-label" >趣味:</label>
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
                <label class="form-label" for="country">国:</label>
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
            <label for="password">パスワード（変更しない場合は空白のままにしてください:</label>
            <input class="form-control" type="password" name="password">
            @error('password')
                <p style="color: red;">{{ $message }}</p>
            @enderror

            </div>

            <div class="mb-3">
                <label for="profile_picture">プロフィール画像:</label>
                @if ($customer->profile_picture)
                    <img src="{{ asset('storage/' . $customer->profile_picture) }}" alt="Profile Picture" width="100">
                @endif
                <input class="form-control"  type="file" name="profile_picture" id="profile_picture">
                @error('profile_picture')
                    <p style="color: red;">{{ $message }}</p>
                @enderror
            </div>

            <button class="btn btn-primary" type="submit">会員編集</button>
        </form>
    </div>
</body>
@include('footer')
</html>
