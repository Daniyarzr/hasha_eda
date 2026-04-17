@extends('layouts.app')

@section('title', 'Личный кабинет — Наша Еда')

@section('content')
    @php
        $activeOrdersCount = $orders->whereIn('status', ['new', 'processing'])->count();
        $lastOrder = $orders->first();
        $lastOrderDate = $lastOrder ? (($lastOrder->ordered_at ?? $lastOrder->created_at)?->format('d.m.Y H:i')) : null;
    @endphp

    <section class="section-title" style="margin-top: 0;">
        <h1 class="headline" style="font-size: clamp(34px, 5vw, 52px);">Личный кабинет</h1>
    </section>

    <section class="grid-2" style="align-items: start;">
        <article class="card">
            <h2 class="headline" style="font-size: 28px;">Профиль</h2>
            <p class="muted" style="margin-top: 8px;">Эти данные подставляются в форму оформления заказа.</p>

            <form method="POST" action="{{ route('account.update') }}" style="margin-top: 14px;">
                @csrf
                @method('PATCH')

                <div class="form-group">
                    <label for="name">Имя</label>
                    <input id="name" type="text" name="name" required value="{{ old('name', $user->name) }}">
                </div>

                <div class="form-group">
                    <label for="phone">Телефон</label>
                    <input id="phone" type="text" name="phone" value="{{ old('phone', $user->phone) }}">
                </div>

                <div class="form-group">
                    <label for="default_address">Адрес по умолчанию</label>
                    <input id="default_address" type="text" name="default_address" value="{{ old('default_address', $user->default_address) }}">
                </div>

                <button type="submit" class="btn btn-primary">Сохранить профиль</button>
            </form>
        </article>

        <article class="card">
            <h2 class="headline" style="font-size: 28px;">Статистика</h2>
            <div class="stats-grid" style="margin-top: 12px;">
                <div class="stat">
                    <small>Всего заказов</small>
                    <strong>{{ $orders->count() }}</strong>
                </div>
                <div class="stat">
                    <small>В обработке</small>
                    <strong>{{ $activeOrdersCount }}</strong>
                </div>
                <div class="stat">
                    <small>Потрачено</small>
                    <strong>{{ number_format((float) $totalSpent, 0) }} ₽</strong>
                </div>
            </div>
            <p class="muted" style="margin-top: 12px;">
                Последний заказ:
                <strong>{{ $lastOrderDate ?? 'пока нет заказов' }}</strong>
            </p>
        </article>
    </section>

    <section class="section-title">
        <h2 class="headline">История заказов</h2>
    </section>

    @if($orders->isEmpty())
        <div class="empty">У вас пока нет заказов. Добавьте блюда в корзину и оформите первый заказ.</div>
    @else
        <section class="order-list">
            @foreach($orders as $order)
                @php
                    $statusClass = match($order->status) {
                        'processing' => 'status-processing',
                        'delivered' => 'status-delivered',
                        'cancelled' => 'status-cancelled',
                        default => 'status-new',
                    };

                    $statusLabel = match($order->status) {
                        'processing' => 'Готовится',
                        'delivered' => 'Доставлен',
                        'cancelled' => 'Отменён',
                        default => 'Новый',
                    };

                    $orderedAt = $order->ordered_at ?? $order->created_at;
                    $itemCount = (int) $order->items->sum('quantity');
                    $itemsSubtotal = $order->items->sum(fn ($item) => (float) $item->price * $item->quantity);
                    $deliveryFee = (float) ($order->delivery_fee ?? 0);
                @endphp

                <article class="card order-card">
                    <div class="order-head">
                        <div>
                            <h3 class="headline order-title">Заказ #{{ $order->id }}</h3>
                            <p class="muted order-subtitle">
                                {{ $order->restaurant?->name ?? 'Ресторан' }} • {{ $orderedAt?->format('d.m.Y H:i') }}
                            </p>
                        </div>

                        <div class="order-badges">
                            <span class="badge-status {{ $statusClass }}">{{ $statusLabel }}</span>
                            <span class="pill">Позиций: {{ $itemCount }}</span>
                            <span class="pill">Итого: {{ number_format((float) $order->total_amount, 0) }} ₽</span>
                        </div>
                    </div>

                    <div class="order-info-grid">
                        <div class="order-info-item">
                            <p class="order-info-label">Адрес доставки</p>
                            <p class="order-info-value">{{ $order->delivery_address }}</p>
                        </div>
                        <div class="order-info-item">
                            <p class="order-info-label">Телефон</p>
                            <p class="order-info-value">{{ $order->customer_phone }}</p>
                        </div>
                    </div>

                    @if($order->comment)
                        <div class="order-note">
                            <p class="order-info-label">Комментарий к заказу</p>
                            <p class="order-info-value">{{ $order->comment }}</p>
                        </div>
                    @endif

                    <div class="table-card order-table-card">
                        <div class="table-wrap">
                            <table class="table order-table">
                                <thead>
                                    <tr>
                                        <th>Блюдо</th>
                                        <th>Кол-во</th>
                                        <th>Цена</th>
                                        <th>Сумма</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($order->items as $item)
                                        <tr>
                                            <td>{{ $item->dish_name }}</td>
                                            <td>{{ $item->quantity }} шт.</td>
                                            <td>{{ number_format((float) $item->price, 0) }} ₽</td>
                                            <td>{{ number_format((float) $item->price * $item->quantity, 0) }} ₽</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4">Состав заказа недоступен.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th colspan="3">Блюда</th>
                                        <th>{{ number_format((float) $itemsSubtotal, 0) }} ₽</th>
                                    </tr>
                                    <tr>
                                        <th colspan="3">Доставка</th>
                                        <th>{{ number_format($deliveryFee, 0) }} ₽</th>
                                    </tr>
                                    <tr>
                                        <th colspan="3">Итого</th>
                                        <th>{{ number_format((float) $order->total_amount, 0) }} ₽</th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </article>
            @endforeach
        </section>
    @endif
@endsection
