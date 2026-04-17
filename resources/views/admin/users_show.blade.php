@extends('layouts.app')

@section('title', $user->name . ' — админка')

@section('content')
    <section class="page-head" style="margin-top: 0;">
        <h1 class="headline" style="font-size: clamp(28px, 5vw, 40px);">{{ $user->name }}</h1>
        <div class="actions-row">
            <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-secondary">Редактировать</a>
            <a href="{{ route('admin.users.index') }}" class="btn btn-ghost">Назад</a>
        </div>
    </section>

    <div class="admin-layout">
        @include('admin._nav')

        <div class="admin-main">
            <section class="grid-2" style="align-items: start;">
                <article class="card">
                    <h2 class="headline" style="font-size: 24px;">Профиль</h2>
                    <div class="detail-list">
                        <p><strong>ID:</strong> {{ $user->id }}</p>
                        <p><strong>Имя:</strong> {{ $user->name }}</p>
                        <p><strong>E-mail:</strong> {{ $user->email }}</p>
                        <p><strong>Телефон:</strong> {{ $user->phone ?: '—' }}</p>
                        <p><strong>Адрес:</strong> {{ $user->default_address ?: '—' }}</p>
                        <p><strong>Роль:</strong> {{ $user->is_admin ? 'Администратор' : 'Пользователь' }}</p>
                        <p><strong>Дата регистрации:</strong> {{ $user->created_at->format('d.m.Y H:i') }}</p>
                    </div>
                </article>

                <article class="card">
                    <h2 class="headline" style="font-size: 24px;">Активность</h2>
                    <div class="meta-row" style="margin-top: 10px;">
                        <span class="pill">Заказов: {{ $user->orders_count }}</span>
                        <span class="pill">Отзывов: {{ $user->reviews_count }}</span>
                        <span class="pill">Товаров в корзине: {{ $user->cart_items_count }}</span>
                    </div>

                    <div class="actions-row" style="margin-top: 14px;">
                        <a class="btn btn-secondary" href="{{ route('admin.orders.index') }}">Все заказы</a>
                    </div>
                </article>
            </section>
        </div>
    </div>
@endsection
