@include('header')
<body>
    <div class="container">
        <h2 class="mt-5">ユーザープロフィール</h2>
        <div class="card">
            <div class="card-body">
                <p class="card-text"><strong>ID:</strong> {{ $customer->registration_id }}</p>
                <p class="card-text"><strong>名前:</strong> {{ $customer->name }}</p>
                <p class="card-text"><strong>メール:</strong> {{ $customer->email }}</p>
                <p class="card-text"><strong>性別:</strong> {{ $customer->gender ? ucfirst($customer->gender) : '情報がありません' }}</p>
                <p class="card-text"><strong>国:</strong> {{ $customer->country ?? '情報がありません' }}</p>
                <p class="card-text"><strong>趣味:</strong>
                        @if($customer->hobbies)
                            {{ implode(', ', json_decode($customer->hobbies)) }}
                        @else
                            No hobbies
                        @endif
                </p>
                @if ($customer->profile_picture)
                    <p><strong>プロフィール画像:</strong></p>
                    <img src="{{ asset('storage/' . $customer->profile_picture) }}" alt="Profile Picture" width="150">
                @else
                    <p>画像なし</p>
                @endif

            </div>
            <a href="{{ route('mypage.edit') }}" class="btn btn-primary">プロフィール編集</a>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
@include('footer')
</html>
