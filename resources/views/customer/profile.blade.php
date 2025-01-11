@include('header')
<body>
    <div class="container">
        <h2 class="mt-5">ユーザープロフィール</h2>
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Thông tin cá nhân</h5>
                <p class="card-text"><strong>ID:</strong> {{ $customer->registration_id }}</p>
                <p class="card-text"><strong>Họ tên:</strong> {{ $customer->name }}</p>
                <p class="card-text"><strong>Email:</strong> {{ $customer->email }}</p>
                <p class="card-text"><strong>Giới tính:</strong> {{ $customer->gender ? ucfirst($customer->gender) : 'Chưa có thông tin' }}</p>
                <p class="card-text"><strong>Quốc gia:</strong> {{ $customer->country ?? 'Chưa có thông tin' }}</p>
                <p class="card-text"><strong>Sở thích:</strong>
                        @if($customer->hobbies)
                            {{ implode(', ', json_decode($customer->hobbies)) }}
                        @else
                            No hobbies
                        @endif
                </p>
                @if ($customer->profile_picture)
                    <p><strong>Ảnh đại diện:</strong></p>
                    <img src="{{ asset('storage/' . $customer->profile_picture) }}" alt="Profile Picture" width="150">
                @else
                    <p>Chưa có ảnh đại diện.</p>
                @endif

            </div>
            <a href="{{ route('mypage.edit') }}" class="btn btn-primary">Chỉnh sửa thông tin</a>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
@include('footer')
</html>
