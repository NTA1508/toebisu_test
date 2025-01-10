<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Danh sách quản trị viên</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f4f4f4;
        }
    </style>
</head>
<body>
    <h1>Danh sách quản trị viên</h1>

    <!-- Form tìm kiếm -->
    <form action="{{ route('admin.member.index') }}" method="GET">
        <input type="text" name="search" value="{{ $search }}" placeholder="Search member...">
        <button type="submit">Search</button>
        <a href="{{ route('admin.member.exportCsv') }}">Export CSV</a>
    </form>

    <!-- Hiển thị danh sách quản trị viên -->
    <table>
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
                        <a href="{{ route('admin.member.edit', $admin->id) }}">Edit</a>
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
</body>
</html>
