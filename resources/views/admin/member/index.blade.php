@include('header')
<body>
    <div class="container mt-5">
        <h1 class="text-center mb-4">管理者一覧</h1>

        <!-- Form tìm kiếm -->
        <form action="{{ route('admin.member.index') }}" method="GET">
            <input type="text" name="search" value="{{ $search }}" placeholder="顧客を検索...">
            <button class="btn btn-primary" type="submit">検索</button>
            <a href="{{ route('admin.member.exportCsv') }}">CSV出力</a>
        </form>

        <a class="btn btn-success" href="/admin/member/new">管理者登録</a>
        <!-- Hiển thị danh sách quản trị viên -->
        <table class="table mt-5">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>名前</th>
                    <th>メール</th>
                    <th>参加日</th>
                    <th>操作</th>
                </tr>
            </thead>
            <tbody>
                @forelse($admins as $admin)
                    <tr>
                        <td>{{ $admin->registration_id }}</td>
                        <td>{{ $admin->name }}</td>
                        <td>{{ $admin->email }}</td>
                        <td>{{ $admin->created_at }}</td>
                        <td>
                            <a class="btn btn-success" href="{{ route('admin.member.edit', $admin->id) }}">編集</a>
                            <form action="{{ route('admin.destroy', $admin->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                            <button class="btn btn-danger" type="submit">削除</button>
                        </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="10">管理者が見つかりません</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <!-- Phân trang -->
        <div>
            {{ $admins->appends(['search' => $search])->links() }}
        </div>
    </div>
</body>
@include('footer')
</html>
