<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profile</title>
    <!-- Link Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center mb-4">Edit Profile</h1>
        <form action="{{ route('mypage.update') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <!-- Name -->
            <div class="mb-3">
            <label for="registration_id">ID:</label>
                <input type="text" class="form-control" id="registration_id" name="registration_id" value="{{ old('registration_id', $customer->registration_id) }}"  required maxlength="8">
                @error('registration_id')
                    <p style="color: red;">{{ $message }}</p>
                @enderror
            </div>

            <!-- Name -->
            <div class="mb-3">
                <label for="name" class="form-label">Name</label>
                <input type="text" class="form-control" id="name" name="name" 
                    value="{{ old('name', $customer->name) }}" placeholder="Enter your name">
                @error('name')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <!-- Email -->
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" 
                    value="{{ old('email', $customer->email) }}" placeholder="Enter your email">
                @error('email')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <!-- Country Dropdown -->
            <div class="mb-3">
                <label for="country" class="form-label">Country</label>
                <select class="form-select" id="country" name="country">
                    <option value="">Select a country</option>
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
                <label for="password">Mật khẩu (để trống nếu không thay đổi):</label>
                <input type="password" class="form-control" name="password">
                @error('password')
                    <p style="color: red;">{{ $message }}</p>
                @enderror
            </div>

            <!-- Gender Radio -->
            <div class="mb-3">
                <label class="form-label">Gender</label>
                <div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="gender" id="male" value="male" 
                            {{ $customer->gender == 'male' ? 'checked' : '' }}>
                        <label class="form-check-label" for="male">Male</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="gender" id="female" value="female" 
                            {{ $customer->gender == 'female' ? 'checked' : '' }}>
                        <label class="form-check-label" for="female">Female</label>
                    </div>
                </div>
                @error('gender')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <!-- Hobbies Checkboxes -->
            <div class="mb-3">
                <label class="form-label">Hobbies</label>
                <div>
                    @foreach ($hobbies as $hobby)
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="hobbies[]" id="hobby_{{ $hobby }}" 
                                value="{{ $hobby }}" {{ in_array($hobby, $selectedHobbies) ? 'checked' : '' }}>
                            <label class="form-check-label" for="hobby_{{ $hobby }}">{{ $hobby }}</label>
                        </div>
                    @endforeach
                </div>
                @error('hobbies')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <!-- Profile Picture -->
            <div class="mb-3">
                <label for="profile_picture" class="form-label">Profile Picture</label>
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
</html>
