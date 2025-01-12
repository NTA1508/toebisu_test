@include('header')
<body>
    <div class="container mt-5">
        <h1 class="text-center mb-4">Danh sách quản trị viên</h1>

        <!-- Form tìm kiếm -->
        <form action="{{ route('admin.member.index') }}" method="GET">
            <input type="text" name="search" value="{{ $search }}" placeholder="Search member...">
            <button class="btn btn-primary" type="submit">Search</button>
            <a href="{{ route('admin.member.exportCsv') }}">Export CSV</a>
        </form>

        <a class="btn btn-success" href="/admin/member/new">Add member</a>
        <!-- Hiển thị danh sách quản trị viên -->
        <table class="table mt-5">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Tên</th>
                    <th>Email</th>
                    <th>Ngày tạo</th>
                    <th>Hành động</th>
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
                            <a class="btn btn-success" href="{{ route('admin.member.edit', $admin->id) }}">Edit</a>
                            <form action="{{ route('admin.destroy', $admin->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE') <!-- Laravel dùng phương thức DELETE để xử lý xóa -->
                            <button class="btn btn-danger" type="submit">Delete</button>
                        </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5">Không tìm thấy quản trị viên nào.</td>
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
