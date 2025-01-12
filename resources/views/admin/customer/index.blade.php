@include('header')
<body>
    <div class="container mt-5">
    <h1  class="text-center mb-4">会員一覧</h1>

    <!-- Form tìm kiếm -->
    <form action="{{ route('admin.customer.index') }}" method="GET">
        <input type="text" name="search" value="{{ $search }}" placeholder="顧客を検索...">
        <button class="btn btn-primary" type="submit">検索</button>
        <a href="{{ route('admin.customer.exportCsv') }}">CSV出力</a>
    </form>

    <a class="btn btn-success" href="/admin/customer/new">会員登録</a>
    <!-- Hiển thị danh sách khách hàng -->
    <table class="table mt-5">
        <thead>
            <tr>
                <th>ID</th>
                <th>プロフィール画像</th>
                <th>名前</th>
                <th>メール</th>
                <th>参加日</th>
                <th>性別</th>
                <th>趣味</th>
                <th>国</th>
                <th>操作</th>
            </tr>
        </thead>
        <tbody>
            @forelse($customers as $customer)
                <tr>
                    <td>{{ $customer->registration_id }}</td> <!-- Hiển thị Registration ID -->
                    <td>
                        @if($customer->profile_picture)
                            <img src="{{ asset('storage/' . $customer->profile_picture) }}" alt="Profile Picture" width="50" height="50">
                        @else
                            画像なし
                        @endif
                    </td>
                    <td>{{ $customer->name }}</td>
                    <td>{{ $customer->email }}</td>
                    <td>{{ $customer->created_at }}</td>
                    <td>{{ ucfirst($customer->gender) }}</td>
                    <td>
                        @if($customer->hobbies)
                            {{ implode(', ', json_decode($customer->hobbies)) }}
                        @else
                            趣味なし
                        @endif
                    </td>
                    <td>{{ $customer->country }}</td>
                    <td>
                        <a class="btn btn-success" href="{{ route('admin.customer.edit', $customer->id) }}">編集</a>
                        <form action="{{ route('customer.destroy', $customer->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger" type="submit">削除</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="10">会員が見つかりません</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div>
        {{ $customers->appends(['search' => $search])->links() }}
    </div>
    </div>
</body>
@include('footer')
</html>
