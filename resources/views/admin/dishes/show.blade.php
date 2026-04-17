@extends('layouts.app')

@section('title', $dish->name . ' — админка')

@section('content')
    <section class="page-head" style="margin-top: 0;">
        <h1 class="headline" style="font-size: clamp(28px, 5vw, 40px);">{{ $dish->name }}</h1>
        <div class="actions-row">
            <a href="{{ route('admin.dishes.edit', $dish) }}" class="btn btn-secondary">Редактировать</a>
            <a href="{{ route('admin.dishes.index') }}" class="btn btn-ghost">Назад</a>
        </div>
    </section>

    <div class="admin-layout">
        @include('admin._nav')

        <div class="admin-main">
            <section class="grid-2" style="align-items: start;">
                <article class="card">
                    <div class="dish-media">
                        <img src="{{ asset(ltrim($dish->image_url, '/')) }}" alt="{{ $dish->name }}">
                    </div>

                    <h2 class="headline" style="font-size: 24px;">Описание</h2>
                    <p class="muted" style="margin-top: 8px;">{{ $dish->description ?: 'Описание не заполнено.' }}</p>
                </article>

                <article class="card">
                    <h2 class="headline" style="font-size: 24px;">Детали</h2>
                    <div class="detail-list">
                        <p><strong>ID:</strong> {{ $dish->id }}</p>
                        <p><strong>Ресторан:</strong> {{ $dish->restaurant?->name ?? '—' }}</p>
                        <p><strong>Цена:</strong> {{ number_format((float) $dish->price, 0) }} ₽</p>
                        <p><strong>Вес:</strong> {{ $dish->weight_grams ? $dish->weight_grams . ' г' : '—' }}</p>
                        <p><strong>Статус:</strong> {{ $dish->is_available ? 'В наличии' : 'Скрыто' }}</p>
                        <p><strong>Путь к картинке:</strong> <code>{{ $dish->image }}</code></p>
                    </div>
                </article>
            </section>
        </div>
    </div>
@endsection
