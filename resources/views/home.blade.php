@extends('layouts.app')

@section('title', 'Наша Еда — доставка еды')

@section('content')
    <section class="hero">
        <div class="card">
            <h1 class="headline hero-title">Доставка еды для города за 30–40 минут</h1>
            <p class="muted" style="margin-top: 14px;">
               Сервис доставки еды.У нас вы можете заказать блюда из ресторана и продукты из магазина.
            </p>

            <div class="stats-grid">
                <div class="stat">
                    <strong>{{ $stats['restaurants'] }}</strong>
                    <span>активных ресторанов</span>
                </div>
                <div class="stat">
                    <strong>{{ $stats['dishes'] }}</strong>
                    <span>доступных блюд</span>
                </div>
                <div class="stat">
                    <strong>{{ $stats['avgDelivery'] }} мин</strong>
                    <span>средняя доставка</span>
                </div>
            </div>
        </div>

        <div class="card">
            <h2 class="headline" style="font-size: 28px;">Как это работает</h2>
            <p class="muted" style="margin-top: 8px;">Выберите ресторан, добавьте блюда в корзину, оформите заказ и отслеживайте историю в кабинете.</p>

            <div class="meta-row" style="margin-top: 14px;">
                <span class="pill">Каталог</span>
                <span class="pill">Корзина</span>
                <span class="pill">Оформление</span>
                <span class="pill">Кабинет</span>
            </div>

            <div class="actions-row" style="margin-top: 18px;">
                <a class="btn btn-secondary" href="{{ route('restaurants.index') }}">Открыть меню</a>
                @guest
                    <a class="btn btn-primary" href="{{ route('register') }}">Создать аккаунт</a>
                @endguest
                @auth
                    <a class="btn btn-primary" href="{{ route('account.index') }}">Перейти в кабинет</a>
                @endauth
            </div>
        </div>
    </section>

    <section class="section-title">
        <h2 class="headline">Популярные рестораны</h2>
        <a class="btn btn-ghost" href="{{ route('restaurants.index') }}">Смотреть все</a>
    </section>

    @if($restaurants->isEmpty())
        <div class="empty">Пока нет данных. Выполните <code>php artisan migrate:fresh --seed</code>.</div>
    @else
        <section class="grid-3">
            @foreach($restaurants as $restaurant)
                <article class="card">
                    <div class="restaurant-media">
                        <img src="{{ asset(ltrim($restaurant->image_url, '/')) }}" alt="Логотип {{ $restaurant->name }}" loading="lazy">
                    </div>

                    <h3 class="headline" style="font-size: 24px;">{{ $restaurant->name }}</h3>
                    <p class="muted" style="margin-top: 8px;">{{ $restaurant->description }}</p>

                    <div class="meta-row">
                        <span class="pill">{{ $restaurant->cuisine }}</span>
                        <span class="pill">{{ number_format((float) $restaurant->rating, 1) }}/5</span>
                        <span class="pill">{{ $restaurant->delivery_time }} мин</span>
                        <span class="pill">{{ $restaurant->available_dishes_count }} блюд</span>
                    </div>

                    <div class="actions-row">
                        <a class="btn btn-secondary" href="{{ route('restaurants.show', $restaurant->slug) }}">Открыть ресторан</a>
                    </div>
                </article>
            @endforeach
        </section>
    @endif

    <section class="section-title">
        <h2 class="headline">Новые блюда</h2>
    </section>

    @if($featuredDishes->isEmpty())
        <div class="empty">Список блюд появится после заполнения базы.</div>
    @else
        <section class="grid-3">
            @foreach($featuredDishes as $dish)
                <article class="card">
                    <div class="dish-media">
                        <img src="{{ asset(ltrim($dish->image_url, '/')) }}" alt="{{ $dish->name }}" loading="lazy">
                    </div>

                    <h3 class="headline" style="font-size: 22px;">{{ $dish->name }}</h3>
                    <p class="muted" style="margin-top: 8px;">{{ $dish->restaurant?->name ?? 'Ресторан' }}</p>
                    <p class="muted" style="margin-top: 8px;">{{ $dish->description }}</p>

                    <div class="actions-row">
                        <span class="price">{{ number_format((float) $dish->price, 0) }} ₽</span>

                        @auth
                            <form method="POST" action="{{ route('cart.store') }}">
                                @csrf
                                <input type="hidden" name="dish_id" value="{{ $dish->id }}">
                                <button type="submit" class="btn btn-orange">В корзину</button>
                            </form>
                        @endauth

                        @guest
                            <a class="btn btn-orange" href="{{ route('login') }}">Войти для заказа</a>
                        @endguest
                    </div>
                </article>
            @endforeach
        </section>
    @endif
@endsection
