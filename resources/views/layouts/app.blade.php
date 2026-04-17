<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Наша Еда')</title>
    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon1.ico?v=2') }}">
    <link rel="shortcut icon" href="{{ asset('favicon1.ico?v=2') }}">
    <link rel="manifest" href="{{ asset('site.webmanifest') }}">
    <meta name="theme-color" content="#1451ac">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700&family=Rubik:wght@500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/mvp.css') }}">
</head>
<body>
    @php
        $cartCount = auth()->check() ? auth()->user()->cartItems()->sum('quantity') : 0;
    @endphp

    <div class="bg-orb bg-orb-yellow"></div>
    <div class="bg-orb bg-orb-purple"></div>
    <div class="bg-orb bg-orb-green"></div>

    <header class="site-header">
        <div class="container header-inner">
            <a class="brand" href="{{ route('home') }}">
                
                <span>Наша Еда</span>
            </a>

            <nav class="main-nav">
                <a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'active' : '' }}">Главная</a>
                <a href="{{ route('catalog.index') }}" class="{{ request()->routeIs('catalog.*') ? 'active' : '' }}">Каталог блюд</a>
                <a href="{{ route('restaurants.index') }}" class="{{ request()->routeIs('restaurants.*') ? 'active' : '' }}">Рестораны</a>

                @auth
                    <a href="{{ route('cart.index') }}" class="{{ request()->routeIs('cart.*') ? 'active' : '' }}">
                        Корзина
                        <span class="nav-badge">{{ $cartCount }}</span>
                    </a>
                    <a href="{{ route('account.index') }}" class="{{ request()->routeIs('account.*') ? 'active' : '' }}">Кабинет</a>

                    @if(auth()->user()->is_admin)
                        <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.*') ? 'active' : '' }}">Админка</a>
                    @endif
                @endauth
            </nav>

            <div class="header-actions">
                @guest
                    <a class="btn btn-ghost" href="{{ route('login') }}">Вход</a>
                    <a class="btn btn-primary" href="{{ route('register') }}">Регистрация</a>
                @endguest

                @auth
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button class="btn btn-primary" type="submit">Выйти</button>
                    </form>
                @endauth
            </div>
        </div>
    </header>

    <main class="container page-content">
        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if (session('error'))
            <div class="alert alert-error">{{ session('error') }}</div>
        @endif

        @if ($errors->any())
            <div class="alert alert-error">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @yield('content')
    </main>
</body>
</html>
