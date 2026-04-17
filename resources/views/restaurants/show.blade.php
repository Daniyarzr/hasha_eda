@extends('layouts.app')

@section('title', $restaurant->name . ' — Наша Еда')

@section('content')
    <section class="card">
        <div class="restaurant-header">
            <div class="restaurant-logo">
                <img src="{{ asset(ltrim($restaurant->image_url, '/')) }}" alt="Логотип {{ $restaurant->name }}" loading="lazy">
            </div>
            <div>
                <h1 class="headline" style="font-size: clamp(34px, 5vw, 52px);">{{ $restaurant->name }}</h1>
                <p class="muted" style="margin-top: 10px;">{{ $restaurant->description }}</p>
            </div>
        </div>

        <div class="meta-row">
            <span class="pill">{{ $restaurant->cuisine }}</span>
            <span class="pill">Рейтинг {{ number_format((float) $restaurant->rating, 1) }}/5</span>
            <span class="pill">{{ $restaurant->delivery_time }} мин</span>
            <span class="pill">От {{ number_format((float) $restaurant->min_order_amount, 0) }} ₽</span>
            <span class="pill">Доставка {{ number_format((float) $restaurant->delivery_fee, 0) }} ₽</span>
        </div>
    </section>

    @php
        $dishesByCategory = $restaurant->dishes->groupBy('category_id');
    @endphp

    @foreach($restaurant->categories as $category)
        @php
            $categoryDishes = $dishesByCategory->get($category->id, collect());
        @endphp

        @if($categoryDishes->isNotEmpty())
            <section class="section-title">
                <h2 class="headline">{{ $category->name }}</h2>
            </section>

            <section class="grid-3">
                @foreach($categoryDishes as $dish)
                    <article class="card">
                        <div class="dish-media">
                            <img src="{{ asset(ltrim($dish->image_url, '/')) }}" alt="{{ $dish->name }}" loading="lazy">
                        </div>

                        <h3 class="headline" style="font-size: 24px;">{{ $dish->name }}</h3>
                        <p class="muted" style="margin-top: 8px;">{{ $dish->description }}</p>

                        <div class="meta-row">
                            @if($dish->weight_grams)
                                <span class="pill">{{ $dish->weight_grams }} г</span>
                            @endif
                            <span class="pill">В наличии</span>
                        </div>

                        <div class="actions-row">
                            <span class="price">{{ number_format((float) $dish->price, 0) }} ₽</span>

                            @auth
                                <form method="POST" action="{{ route('cart.store') }}" style="display:flex; gap:8px; align-items:center;">
                                    @csrf
                                    <input type="hidden" name="dish_id" value="{{ $dish->id }}">
                                    <input type="number" min="1" max="20" value="1" name="quantity" style="width:80px;">
                                    <button type="submit" class="btn btn-orange">Добавить</button>
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
    @endforeach

    <section class="section-title">
        <h2 class="headline">Последние отзывы</h2>
    </section>

    @if($restaurant->reviews->isEmpty())
        <div class="empty">Пока нет отзывов.</div>
    @else
        <section class="grid-2">
            @foreach($restaurant->reviews->take(6) as $review)
                <article class="card">
                    <div class="meta-row">
                        <span class="pill">{{ $review->rating }}/5</span>
                        <span class="pill">{{ $review->user?->name ?? 'Пользователь' }}</span>
                    </div>
                    <p class="muted" style="margin-top: 10px;">{{ $review->comment ?: 'Без текста.' }}</p>
                </article>
            @endforeach
        </section>
    @endif
@endsection
