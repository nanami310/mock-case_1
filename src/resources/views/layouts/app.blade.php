<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Attendance Management</title>
  <link rel="stylesheet" href="{{ asset('css/sanitize.css') }}">
  <link rel="stylesheet" href="{{ asset('css/layouts/app.css') }}">
  @yield('css')
</head>

<body>
  <header class="header">
    <div class="header__inner">
      <div class="header-logo">
        <a class="header__logo" href="{{ Auth::check() ? '/' : route('login') }}">
          <img src="{{ asset('storage/images/logo.svg') }}" alt="Attendance Management Logo" class="logo-img">
        </a>
      </div>
      @if (Auth::check())
      <div class="header-utilities">
        <form action="{{ route('products.index') }}" method="GET" class="search-form">
          <input type="text" name="search" value="{{ request('search') }}" placeholder="なにをお探しですか？" oninput="this.form.submit()">
        </form>
      </div>
      <nav>
        <ul class="header-nav">
          
          <li class="header-nav__item">
            <form class="form" action="/logout" method="post">
              @csrf
              <button class="header-nav__button">ログアウト</button>
            </form>
          </li>
          <li class="header-nav__item">
            <a class="header-nav__link" href="/mypage">マイページ</a>
          </li>
          
        </ul>
      </nav>
      <nav>
        <ul class="header-nav">
          <li class="header-nav__item">
            <a href="{{ route('products.create') }}" class="btn btn-primary">出品</a>
          </li>
        </ul>
      </nav>
      @endif
    </div>
  </header>

  <main>
    @yield('content')
  </main>
</body>

</html>
