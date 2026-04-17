<nav class="admin-tabs">
    <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">Обзор</a>
    <a href="{{ route('admin.users.index') }}" class="{{ request()->routeIs('admin.users.*') ? 'active' : '' }}">Пользователи</a>
    <a href="{{ route('admin.restaurants.index') }}" class="{{ request()->routeIs('admin.restaurants.*') ? 'active' : '' }}">Рестораны</a>
    <a href="{{ route('admin.dishes.index') }}" class="{{ request()->routeIs('admin.dishes.*') ? 'active' : '' }}">Блюда</a>
    <a href="{{ route('admin.orders.index') }}" class="{{ request()->routeIs('admin.orders.*') ? 'active' : '' }}">Заказы</a>
</nav>
