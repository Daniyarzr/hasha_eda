@extends('layouts.app')

@section('title', 'Админка: категории')

@section('content')
    <section class="page-head" style="margin-top: 0;">
        <h1 class="headline" style="font-size: clamp(28px, 5vw, 40px);">Категории</h1>
        <a href="{{ route('admin.categories.create') }}" class="btn btn-primary">Добавить категорию</a>
    </section>

    @include('admin._nav')

    <section class="card filters-panel">
        <form method="GET" action="{{ route('admin.categories.index') }}" class="form-grid form-grid-3">
            <div class="form-group">
                <label for="restaurant_id">Ресторан</label>
                <select id="restaurant_id" name="restaurant_id">
                    <option value="">Все рестораны</option>
                    @foreach($restaurants as $restaurant)
                        <option value="{{ $restaurant->id }}" @selected((int) $restaurantId === $restaurant->id)>
                            {{ $restaurant->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="q">Поиск категории</label>
                <input id="q" type="text" name="q" value="{{ $search }}" placeholder="Например: Пицца">
            </div>

            <div class="actions-row">
                <button type="submit" class="btn btn-secondary">Найти</button>
                <a href="{{ route('admin.categories.index') }}" class="btn btn-ghost">Сброс</a>
            </div>
        </form>
    </section>

    @if($categories->isEmpty())
        <div class="empty">Категории не найдены.</div>
    @else
        <section class="table-card">
            <div class="table-wrap">
                <table class="table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Категория</th>
                            <th>Slug</th>
                            <th>Ресторан</th>
                            <th>Порядок</th>
                            <th>Блюд</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($categories as $category)
                            <tr>
                                <td>{{ $category->id }}</td>
                                <td>{{ $category->name }}</td>
                                <td>{{ $category->slug }}</td>
                                <td>{{ $category->restaurant?->name ?? '—' }}</td>
                                <td>{{ $category->sort_order }}</td>
                                <td>{{ $category->dishes_count }}</td>
                                <td class="table-actions">
                                    <a class="btn btn-ghost" href="{{ route('admin.categories.show', $category) }}">Открыть</a>
                                    <a class="btn btn-ghost" href="{{ route('admin.categories.edit', $category) }}">Изменить</a>
                                    <form method="POST" action="{{ route('admin.categories.destroy', $category) }}" onsubmit="return confirm('Удалить категорию?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-danger" type="submit">Удалить</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </section>
    @endif
@endsection
