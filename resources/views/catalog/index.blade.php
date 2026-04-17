@extends('layouts.app')

@section('title', 'Каталог блюд — Наша Еда')

@section('content')
    <section class="page-head" style="margin-top: 0;">
        <h1 class="headline" style="font-size: clamp(30px, 5vw, 46px);">Каталог блюд</h1>
        <p class="muted">Поиск, фильтры по ресторану, категории и цене.</p>
    </section>

    <section class="card filters-panel">
        <form method="GET" action="{{ route('catalog.index') }}" class="form-grid form-grid-6">
            <div class="form-group form-span-2">
                <label for="q">Поиск</label>
                <input id="q" type="text" name="q" value="{{ $filters['q'] }}" placeholder="Название блюда или ресторана">
            </div>

            <div class="form-group">
                <label for="restaurant_id">Ресторан</label>
                <select id="restaurant_id" name="restaurant_id">
                    <option value="">Все рестораны</option>
                    @foreach($restaurants as $restaurant)
                        <option value="{{ $restaurant->id }}" @selected((int) $filters['restaurant_id'] === $restaurant->id)>
                            {{ $restaurant->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="category_id">Категория</label>
                <select id="category_id" name="category_id">
                    <option value="">Все категории</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" @selected((int) $filters['category_id'] === $category->id)>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="price_from">Цена от, ₽</label>
                <input id="price_from" type="number" min="0" step="1" name="price_from" value="{{ $filters['price_from'] }}">
            </div>

            <div class="form-group">
                <label for="price_to">Цена до, ₽</label>
                <input id="price_to" type="number" min="0" step="1" name="price_to" value="{{ $filters['price_to'] }}">
            </div>

            <div class="form-group">
                <label for="sort">Сортировка</label>
                <select id="sort" name="sort">
                    <option value="popular" @selected($filters['sort'] === 'popular')>По умолчанию</option>
                    <option value="new" @selected($filters['sort'] === 'new')>Сначала новые</option>
                    <option value="price_asc" @selected($filters['sort'] === 'price_asc')>Цена по возрастанию</option>
                    <option value="price_desc" @selected($filters['sort'] === 'price_desc')>Цена по убыванию</option>
                </select>
            </div>

            <div class="actions-row form-span-2">
                <button type="submit" class="btn btn-secondary">Применить фильтры</button>
                <a href="{{ route('catalog.index') }}" class="btn btn-ghost">Сбросить</a>
            </div>
        </form>
    </section>

    @if($dishes->isEmpty())
        <div class="empty">По выбранным фильтрам ничего не найдено.</div>
    @else
        <section class="grid-3">
            @foreach($dishes as $dish)
                <article class="card">
                    <div class="dish-media">
                        <img src="{{ asset(ltrim($dish->image_url, '/')) }}" alt="{{ $dish->name }}" loading="lazy">
                    </div>

                    <h2 class="headline" style="font-size: 22px;">{{ $dish->name }}</h2>
                    <p class="muted" style="margin-top: 6px;">{{ $dish->restaurant?->name ?? 'Ресторан' }}</p>
                    <p class="muted" style="margin-top: 8px;">{{ \Illuminate\Support\Str::limit($dish->description ?? 'Описание будет добавлено позже.', 120) }}</p>

                    <div class="meta-row">
                        @if($dish->category)
                            <span class="pill">{{ $dish->category->name }}</span>
                        @endif
                        @if($dish->weight_grams)
                            <span class="pill">{{ $dish->weight_grams }} г</span>
                        @endif
                        <span class="pill">В наличии</span>
                    </div>

                    <div class="actions-row">
                        <span class="price">{{ number_format((float) $dish->price, 0) }} ₽</span>

                        @auth
                            <form method="POST" action="{{ route('cart.store') }}">
                                @csrf
                                <input type="hidden" name="dish_id" value="{{ $dish->id }}">
                                <button type="submit" class="btn btn-orange">В корзину</button>
                            </form>
                        @else
                            <a class="btn btn-orange" href="{{ route('login') }}">Войти для заказа</a>
                        @endauth
                    </div>
                </article>
            @endforeach
        </section>
    @endif
@endsection
