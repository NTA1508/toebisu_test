@include('header')
<body>
    <div class="container mt-5">
    <h1  class="text-center mb-4">Danh sách khách hàng</h1>

    <!-- Form tìm kiếm -->
    <form action="{{ route('admin.customer.index') }}" method="GET">
        <input type="text" name="search" value="{{ $search }}" placeholder="Search customer...">
        <button class="btn btn-primary" type="submit">Search</button>
        <a href="{{ route('admin.customer.exportCsv') }}">Export CSV</a>
    </form>

    <!-- Hiển thị danh sách khách hàng -->
    <table class="table mt-5">
        <thead>
            <tr>
                <th>ID</th>
                <th>Registration ID</th>
                <th>Profile Picture</th>
                <th>Tên</th>
                <th>Email</th>
                <th>Ngày tạo</th>
                <th>Gender</th>
                <th>Hobbies</th>
                <th>Country</th>
                <th>Hành động</th>
            </tr>
        </thead>
        <tbody>
            @forelse($customers as $customer)
                <tr>
                    <td>{{ $customer->id }}</td>
                    <td>{{ $customer->registration_id }}</td> <!-- Hiển thị Registration ID -->
                    <td>
                        @if($customer->profile_picture)
                            <img src="{{ asset('storage/' . $customer->profile_picture) }}" alt="Profile Picture" width="50" height="50">
                        @else
                            No Image
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
                            No hobbies
                        @endif
                    </td>
                    <td>{{ $customer->country }}</td>
                    <td>
                        <a class="btn btn-success" href="{{ route('admin.customer.edit', $customer->id) }}">Chỉnh sửa</a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="10">Không tìm thấy khách hàng nào.</td>
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
