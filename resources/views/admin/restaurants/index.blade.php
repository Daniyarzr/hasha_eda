@extends('layouts.app')

@section('title', 'Админка: рестораны')

@section('content')
    <section class="page-head" style="margin-top: 0;">
        <h1 class="headline" style="font-size: clamp(28px, 5vw, 40px);">Рестораны</h1>
        <a href="{{ route('admin.restaurants.create') }}" class="btn btn-primary">Добавить ресторан</a>
    </section>

    <div class="admin-layout">
        @include('admin._nav')

        <div class="admin-main">
            @if($restaurants->isEmpty())
                <div class="empty">Рестораны пока не добавлены.</div>
            @else
                <section class="table-card">
                    <div class="table-wrap">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Логотип</th>
                                    <th>Название</th>
                                    <th>Кухня</th>
                                    <th>Рейтинг</th>
                                    <th>Блюда</th>
                                    <th>Заказы</th>
                                    <th>Статус</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($restaurants as $restaurant)
                                    <tr>
                                        <td>{{ $restaurant->id }}</td>
                                        <td>
                                            <div class="table-media">
                                                <img src="{{ asset(ltrim($restaurant->image_url, '/')) }}" alt="Логотип {{ $restaurant->name }}" class="thumb" loading="lazy">
                                            </div>
                                        </td>
                                        <td>{{ $restaurant->name }}</td>
                                        <td>{{ $restaurant->cuisine }}</td>
                                        <td>{{ number_format((float) $restaurant->rating, 1) }}</td>
                                        <td>{{ $restaurant->dishes_count }}</td>
                                        <td>{{ $restaurant->orders_count }}</td>
                                        <td>
                                            @if($restaurant->is_active)
                                                <span class="badge-status status-delivered">Активный</span>
                                            @else
                                                <span class="badge-status status-cancelled">Выключен</span>
                                            @endif
                                        </td>
                                        <td class="table-actions">
                                            <a class="btn btn-ghost" href="{{ route('admin.restaurants.show', $restaurant) }}">Открыть</a>
                                            <a class="btn btn-ghost" href="{{ route('admin.restaurants.edit', $restaurant) }}">Изменить</a>
                                            <form method="POST" action="{{ route('admin.restaurants.destroy', $restaurant) }}" onsubmit="return confirm('Удалить ресторан?')">
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
