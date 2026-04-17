@extends('layouts.app')

@section('title', 'Админка — Наша Еда')

@section('content')
    <section class="page-head" style="margin-top: 0;">
        <h1 class="headline" style="font-size: clamp(30px, 5vw, 44px);">Панель администратора</h1>
        <p class="muted">Управление пользователями, каталогом и заказами.</p>
    </section>

    <div class="admin-layout">
        @include('admin._nav')

        <div class="admin-main">
            <section class="grid-3">
                <article class="card">
                    <h2 class="headline" style="font-size: 22px;">Рестораны</h2>
                    <p class="muted" style="margin-top: 8px;">{{ $stats['restaurants'] }} шт.</p>
                    <div class="actions-row">
                        <a class="btn btn-secondary" href="{{ route('admin.restaurants.index') }}">Открыть</a>
                    </div>
                </article>
                <article class="card">
                    <h2 class="headline" style="font-size: 22px;">Пользователи</h2>
                    <p class="muted" style="margin-top: 8px;">{{ $stats['users'] }} шт.</p>
                    <div class="actions-row">
                        <a class="btn btn-secondary" href="{{ route('admin.users.index') }}">Открыть</a>
                    </div>
                </article>
                <article class="card">
                    <h2 class="headline" style="font-size: 22px;">Блюда</h2>
                    <p class="muted" style="margin-top: 8px;">{{ $stats['dishes'] }} шт.</p>
                    <div class="actions-row">
                        <a class="btn btn-secondary" href="{{ route('admin.dishes.index') }}">Открыть</a>
                    </div>
                </article>
                <article class="card">
                    <h2 class="headline" style="font-size: 22px;">Заказы</h2>
                    <p class="muted" style="margin-top: 8px;">Всего: {{ $stats['orders'] }}</p>
                    <p class="muted">Новых: {{ $stats['new_orders'] }}</p>
                    <div class="actions-row">
                        <a class="btn btn-secondary" href="{{ route('admin.orders.index') }}">Открыть</a>
                    </div>
                </article>
            </section>

            <section class="section-title">
                <h2 class="headline">Последние заказы</h2>
            </section>

            @if($recentOrders->isEmpty())
                <div class="empty">Заказов пока нет.</div>
            @else
                <section class="table-card">
                    <div class="table-wrap">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Пользователь</th>
                                    <th>Ресторан</th>
                                    <th>Сумма</th>
                                    <th>Статус</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($recentOrders as $order)
                                    @php
                                        $statusClass = match($order->status) {
                                            'processing' => 'status-processing',
                                            'delivered' => 'status-delivered',
                                            'cancelled' => 'status-cancelled',
                                            default => 'status-new',
                                        };
                                        $statusLabel = match($order->status) {
                                            'processing' => 'В работе',
                                            'delivered' => 'Доставлен',
                                            'cancelled' => 'Отменен',
                                            default => 'Новый',
                                        };
                                    @endphp
                                    <tr>
                                        <td>#{{ $order->id }}</td>
                                        <td>{{ $order->user?->name ?? '—' }}</td>
                                        <td>{{ $order->restaurant?->name ?? '—' }}</td>
                                        <td>{{ number_format((float) $order->total_amount, 0) }} ₽</td>
                                        <td><span class="badge-status {{ $statusClass }}">{{ $statusLabel }}</span></td>
                                        <td class="table-actions">
                                            <a class="btn btn-ghost" href="{{ route('admin.orders.show', $order) }}">Открыть</a>
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
