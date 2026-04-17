@extends('layouts.app')

@section('title', $restaurant->name . ' — админка')

@section('content')
    <section class="page-head" style="margin-top: 0;">
        <h1 class="headline" style="font-size: clamp(28px, 5vw, 40px);">{{ $restaurant->name }}</h1>
        <div class="actions-row">
            <a href="{{ route('admin.restaurants.edit', $restaurant) }}" class="btn btn-secondary">Редактировать</a>
            <a href="{{ route('admin.restaurants.index') }}" class="btn btn-ghost">Назад</a>
        </div>
    </section>

    <div class="admin-layout">
        @include('admin._nav')

        <div class="admin-main">
            <section class="grid-2" style="align-items: start;">
                <article class="card">
                    <h2 class="headline" style="font-size: 24px;">Информация</h2>
                    <div class="table-media" style="margin-top: 10px;">
                        <img src="{{ asset(ltrim($restaurant->image_url, '/')) }}" alt="Логотип {{ $restaurant->name }}" class="thumb" loading="lazy">
                        <code>{{ $restaurant->image_url }}</code>
                    </div>
                    <div class="detail-list">
                        <p><strong>ID:</strong> {{ $restaurant->id }}</p>
                        <p><strong>Slug:</strong> {{ $restaurant->slug }}</p>
                        <p><strong>Кухня:</strong> {{ $restaurant->cuisine }}</p>
                        <p><strong>Адрес:</strong> {{ $restaurant->address }}</p>
                        <p><strong>Доставка:</strong> {{ $restaurant->delivery_time }} мин</p>
                        <p><strong>Стоимость доставки:</strong> {{ number_format((float) $restaurant->delivery_fee, 0) }} ₽</p>
                        <p><strong>Мин. заказ:</strong> {{ number_format((float) $restaurant->min_order_amount, 0) }} ₽</p>
                        <p><strong>Рейтинг:</strong> {{ number_format((float) $restaurant->rating, 1) }}</p>
                        <p><strong>Статус:</strong> {{ $restaurant->is_active ? 'Активный' : 'Выключен' }}</p>
                    </div>
                    <p class="muted" style="margin-top: 10px;">{{ $restaurant->description }}</p>
                </article>

                <article class="card">
                    <h2 class="headline" style="font-size: 24px;">Статистика</h2>
                    <div class="meta-row" style="margin-top: 10px;">
                        <span class="pill">Блюд: {{ $restaurant->dishes_count }}</span>
                        <span class="pill">Заказов: {{ $restaurant->orders_count }}</span>
                        <span class="pill">Отзывов: {{ $restaurant->reviews_count }}</span>
                    </div>
                    <div class="actions-row" style="margin-top: 14px;">
                        <a class="btn btn-secondary" href="{{ route('admin.dishes.index') }}">Блюда</a>
                    </div>
                </article>
            </section>
        </div>
    </div>
@endsection
