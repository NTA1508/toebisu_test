@include('header')
<body>
    <div  class="container mt-5">
        <h1 class="text-center mb-4">
            @auth
                Welcome, {{ Auth::user()->name }}!
            @else
                Welcome to my app
            @endauth
        </h1>
        @guest
            <h2 class="text-center mb-4">You are</h2>
            <div class="text-center">
                <a href="/login" class="btn btn-primary mx-2">Customer</a>
                <a href="/admin/login" class="btn btn-secondary mx-2">Member</a>
            </div>
        @endguest
    </div>
</body>
</html>

