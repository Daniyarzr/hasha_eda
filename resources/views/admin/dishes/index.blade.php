@extends('layouts.app')

@section('title', 'Админка: блюда')

@section('content')
    <section class="page-head" style="margin-top: 0;">
        <h1 class="headline" style="font-size: clamp(28px, 5vw, 40px);">Блюда</h1>
        <a href="{{ route('admin.dishes.create') }}" class="btn btn-primary">Добавить блюдо</a>
    </section>

    <div class="admin-layout">
        @include('admin._nav')

        <div class="admin-main">
            @if($dishes->isEmpty())
                <div class="empty">Блюда не найдены.</div>
            @else
                <section class="table-card">
                    <div class="table-wrap">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Блюдо</th>
                                    <th>Ресторан</th>
                                    <th>Цена</th>
                                    <th>Статус</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($dishes as $dish)
                                    <tr>
                                        <td>{{ $dish->id }}</td>
                                        <td>
                                            <div class="table-media">
                                                <img src="{{ asset(ltrim($dish->image_url, '/')) }}" alt="{{ $dish->name }}" class="thumb">
                                                <span>{{ $dish->name }}</span>
                                            </div>
                                        </td>
                                        <td>{{ $dish->restaurant?->name ?? '—' }}</td>
                                        <td>{{ number_format((float) $dish->price, 0) }} ₽</td>
                                        <td>
                                            @if($dish->is_available)
                                                <span class="badge-status status-delivered">В наличии</span>
                                            @else
                                                <span class="badge-status status-cancelled">Скрыто</span>
                                            @endif
                                        </td>
                                        <td class="table-actions">
                                            <a class="btn btn-ghost" href="{{ route('admin.dishes.show', $dish) }}">Открыть</a>
                                            <a class="btn btn-ghost" href="{{ route('admin.dishes.edit', $dish) }}">Изменить</a>
                                            <form method="POST" action="{{ route('admin.dishes.destroy', $dish) }}" onsubmit="return confirm('Удалить блюдо?')">
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
        </div>
    </div>
@endsection
