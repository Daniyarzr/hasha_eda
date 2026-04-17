@extends('layouts.app')

@section('title', 'Заказ #' . $order->id . ' — админка')

@section('content')
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

    <section class="page-head" style="margin-top: 0;">
        <h1 class="headline" style="font-size: clamp(28px, 5vw, 40px);">Заказ #{{ $order->id }}</h1>
        <div class="actions-row">
            <a href="{{ route('admin.orders.edit', $order) }}" class="btn btn-secondary">Редактировать</a>
            <form method="POST" action="{{ route('admin.orders.destroy', $order) }}" onsubmit="return confirm('Удалить заказ?')">
                @csrf
                @method('DELETE')
                <button class="btn btn-danger" type="submit">Удалить</button>
            </form>
            <a href="{{ route('admin.orders.index') }}" class="btn btn-ghost">Назад</a>
        </div>
    </section>

    <div class="admin-layout">
        @include('admin._nav')

        <div class="admin-main">
            <section class="grid-2" style="align-items: start;">
                <article class="card">
                    <h2 class="headline" style="font-size: 24px;">Информация о заказе</h2>
                    <div class="detail-list">
                        <p><strong>Клиент:</strong> {{ $order->user?->name ?? '—' }}</p>
                        <p><strong>Телефон:</strong> {{ $order->customer_phone }}</p>
                        <p><strong>Ресторан:</strong> {{ $order->restaurant?->name ?? '—' }}</p>
                        <p><strong>Адрес доставки:</strong> {{ $order->delivery_address }}</p>
                        <p><strong>Дата:</strong> {{ optional($order->ordered_at)->format('d.m.Y H:i') ?? $order->created_at->format('d.m.Y H:i') }}</p>
                        <p><strong>Доставка:</strong> {{ number_format((float) $order->delivery_fee, 0) }} ₽</p>
                        <p><strong>Итого:</strong> {{ number_format((float) $order->total_amount, 0) }} ₽</p>
                    </div>

                    @if($order->comment)
                        <p class="muted" style="margin-top: 10px;"><strong>Комментарий к заказу:</strong> {{ $order->comment }}</p>
                    @endif

                    @if($order->review)
                        <div class="meta-row" style="margin-top: 12px;">
                            <span class="pill">Оценка: {{ $order->review->rating }}/5</span>
                        </div>
                        <p class="muted" style="margin-top: 8px;">{{ $order->review->comment ?: 'Без текста отзыва.' }}</p>
                    @endif
                </article>

                <article class="card">
                    <h2 class="headline" style="font-size: 24px;">Статус и детали</h2>
                    <div class="meta-row" style="margin-top: 10px;">
                        <span class="badge-status {{ $statusClass }}">{{ $statusLabel }}</span>
                    </div>
                    <div class="detail-list" style="margin-top: 12px;">
                        <p><strong>ID пользователя:</strong> {{ $order->user_id }}</p>
                        <p><strong>ID ресторана:</strong> {{ $order->restaurant_id }}</p>
                        <p><strong>Создан:</strong> {{ $order->created_at->format('d.m.Y H:i') }}</p>
                        <p><strong>Обновлен:</strong> {{ $order->updated_at->format('d.m.Y H:i') }}</p>
                    </div>
                    <div class="actions-row" style="margin-top: 14px;">
                        <a href="{{ route('admin.orders.edit', $order) }}" class="btn btn-primary">Изменить заказ</a>
                    </div>
                </article>
            </section>

            <section class="section-title">
                <h2 class="headline">Состав заказа</h2>
            </section>

            @if($order->items->isEmpty())
                <div class="empty">Позиции заказа не найдены.</div>
            @else
                <section class="table-card">
                    <div class="table-wrap">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Блюдо</th>
                                    <th>Кол-во</th>
                                    <th>Цена</th>
                                    <th>Сумма</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($order->items as $item)
                                    <tr>
                                        <td>{{ $item->dish_name }}</td>
                                        <td>{{ $item->quantity }}</td>
                                        <td>{{ number_format((float) $item->price, 0) }} ₽</td>
                                        <td>{{ number_format((float) $item->price * $item->quantity, 0) }} ₽</td>
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
