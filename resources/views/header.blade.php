<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Test</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <a class="navbar-brand" href="/"> ビバーです</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarNav">
    <ul class="navbar-nav">
      @guest
          <li class="nav-item active">
              <a class="nav-link" href="/login">会員</a>
          </li>
          <li class="nav-item">
              <a class="nav-link" href="/admin/login">管理者</a>
          </li>
      @else
        @auth('admin')
          <li class="nav-item">
            <a class="nav-link" href="/admin/customer" class="btn btn-primary mx-2">会員</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="/admin/member" class="btn btn-primary mx-2">管理者</a>
          </li>
          <li class="nav-item">
              
              <form action="{{ route('admin.logout') }}" method="POST" style="display: inline;">
                  @csrf
                  <button type="submit" class="nav-link" style="border: none; background: none;">ログアウト</button>
              </form>
          </li>
        @endauth
        @auth('web')
          <li class="nav-item">
            <a class="nav-link" href="/mypage" class="btn btn-primary mx-2">プロフィール</a>
          </li>
          <li class="nav-item">
              <form action="{{ route('customer.logout') }}" method="POST" style="display: inline;">
                  @csrf
                  <button type="submit" class="nav-link" style="border: none; background: none;">ログアウト</button>
              </form>
          </li>
        @endauth
      @endguest
    </ul>
  </div>
</nav>