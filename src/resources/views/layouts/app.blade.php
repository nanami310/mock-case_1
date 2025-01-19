<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Attendance Management</title>
  <link rel="stylesheet" href="{{ asset('css/sanitize.css') }}">
  <link rel="stylesheet" href="{{ asset('css/common.css') }}">
  @yield('css')
</head>

<body>
  <header class="header">
    <div class="header__inner">
      <div class="header-utilities">
        <a class="header__logo" href="/">
          <img src="{{ asset('storage/images/logo.svg') }}" alt="Attendance Management Logo" class="logo-img">
        </a>
        <nav>
          <ul class="header-nav">
            @if (Auth::check())
            <form action="{{ route('products.index') }}" method="GET" class="d-inline">
              <input type="text" name="search" value="{{ request('search') }}" placeholder="商品名で検索">
              <button type="submit">検索</button>
            </form>
            <form class="form" action="/logout" method="post">
              @csrf
              <button class="header-nav__button">ログアウト</button>
            </form>
            <li class="header-nav__item">
              <a class="header-nav__link" href="/mypage">マイページ</a>
            </li>
            <li class="header-nav__item">
              <a href="{{ route('products.create') }}" class="btn btn-primary">出品</a>
            </li>
            @endif
          </ul>
        </nav>
      </div>
    </div>
  </header>

  <main>
    @yield('content')
  </main>
</body>

</html>