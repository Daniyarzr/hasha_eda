@extends('layouts.app')

@section('title', $category->name . ' — админка')

@section('content')
    <section class="page-head" style="margin-top: 0;">
        <h1 class="headline" style="font-size: clamp(28px, 5vw, 40px);">{{ $category->name }}</h1>
        <div class="actions-row">
            <a href="{{ route('admin.categories.edit', $category) }}" class="btn btn-secondary">Редактировать</a>
            <a href="{{ route('admin.categories.index') }}" class="btn btn-ghost">Назад</a>
        </div>
    </section>

    @include('admin._nav')

    <section class="grid-2" style="align-items: start;">
        <article class="card">
            <h2 class="headline" style="font-size: 24px;">Детали</h2>
            <div class="detail-list">
                <p><strong>ID:</strong> {{ $category->id }}</p>
                <p><strong>Slug:</strong> {{ $category->slug }}</p>
                <p><strong>Порядок:</strong> {{ $category->sort_order }}</p>
                <p><strong>Ресторан:</strong> {{ $category->restaurant?->name ?? '—' }}</p>
            </div>
        </article>

        <article class="card">
            <h2 class="headline" style="font-size: 24px;">Блюда в категории</h2>
            @if($category->dishes->isEmpty())
                <p class="muted" style="margin-top: 8px;">Пока нет блюд.</p>
            @else
                <ul class="order-item-list">
                    @foreach($category->dishes as $dish)
                        <li>
                            {{ $dish->name }} — {{ number_format((float) $dish->price, 0) }} ₽
                            <a href="{{ route('admin.dishes.show', $dish) }}">открыть</a>
                        </li>
                    @endforeach
                </ul>
            @endif
        </article>
    </section>
@endsection
