@extends('layouts.app')

@section('title', 'Админка: заказы')

@section('content')
    <section class="page-head" style="margin-top: 0;">
        <h1 class="headline" style="font-size: clamp(28px, 5vw, 40px);">Заказы</h1>
        <a href="{{ route('admin.orders.create') }}" class="btn btn-primary">Добавить заказ</a>
    </section>

    <div class="admin-layout">
        @include('admin._nav')

        <div class="admin-main">
            @if($orders->isEmpty())
                <div class="empty">Заказы не найдены.</div>
            @else
                <section class="table-card">
                    <div class="table-wrap">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Дата</th>
                                    <th>Клиент</th>
                                    <th>Ресторан</th>
                                    <th>Позиций</th>
                                    <th>Сумма</th>
                                    <th>Статус</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($orders as $order)
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
                                        <td>{{ optional($order->ordered_at)->format('d.m.Y H:i') ?? $order->created_at->format('d.m.Y H:i') }}</td>
                                        <td>
                                            {{ $order->user?->name ?? '—' }}<br>
                                            <span class="muted">{{ $order->customer_phone }}</span>
                                        </td>
                                        <td>{{ $order->restaurant?->name ?? '—' }}</td>
                                        <td>{{ $order->items_count }}</td>
                                        <td>{{ number_format((float) $order->total_amount, 0) }} ₽</td>
                                        <td><span class="badge-status {{ $statusClass }}">{{ $statusLabel }}</span></td>
                                        <td class="table-actions">
                                            <a class="btn btn-ghost" href="{{ route('admin.orders.show', $order) }}">Открыть</a>
                                            <a class="btn btn-ghost" href="{{ route('admin.orders.edit', $order) }}">Изменить</a>
                                            <form method="POST" action="{{ route('admin.orders.destroy', $order) }}" onsubmit="return confirm('Удалить заказ?')">
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
