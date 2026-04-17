@extends('layouts.app')

@section('title', 'Корзина — Наша Еда')

@section('content')
    <section class="section-title" style="margin-top: 0;">
        <h1 class="headline" style="font-size: clamp(34px, 5vw, 52px);">Корзина</h1>
    </section>

    @if($items->isEmpty())
        <div class="empty">
            Корзина пуста. Перейдите в <a href="{{ route('restaurants.index') }}"><strong>каталог</strong></a> и выберите блюда.
        </div>
    @else
        <section class="grid-2" style="align-items: start;">
            <div class="order-list">
                @foreach($items as $item)
                    <article class="card">
                        <h2 class="headline" style="font-size: 24px;">{{ $item->dish?->name ?? 'Неизвестное блюдо' }}</h2>
                        <p class="muted" style="margin-top: 6px;">{{ $item->dish?->restaurant?->name ?? 'Неизвестный ресторан' }}</p>

                        <div class="meta-row">
                            <span class="pill">Цена {{ number_format((float) $item->price, 0) }} ₽</span>
                            <span class="pill">Сумма {{ number_format((float) $item->price * $item->quantity, 0) }} ₽</span>
                        </div>

                        <div class="actions-row">
                            <form method="POST" action="{{ route('cart.update', $item->id) }}" style="display:flex; align-items:center; gap:8px;">
                                @csrf
                                @method('PATCH')
                                <input type="number" min="1" max="99" name="quantity" value="{{ $item->quantity }}" style="width: 88px;">
                                <button class="btn btn-secondary" type="submit">Обновить</button>
                            </form>

                            <form method="POST" action="{{ route('cart.destroy', $item->id) }}">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger" type="submit">Удалить</button>
                            </form>
                        </div>
                    </article>
                @endforeach
            </div>

            <aside class="card">
                <h2 class="headline" style="font-size: 28px;">Оформление заказа</h2>

                <div class="meta-row" style="margin-top: 10px;">
                    <span class="pill">Товары {{ number_format((float) $subtotal, 0) }} ₽</span>
                    <span class="pill">Доставка {{ number_format((float) $deliveryFee, 0) }} ₽</span>
                    <span class="pill"><strong>Итого {{ number_format((float) $total, 0) }} ₽</strong></span>
                </div>

                <form method="POST" action="{{ route('checkout.store') }}" style="margin-top: 14px;">
                    @csrf

                    <div class="form-group">
                        <label for="delivery_address">Адрес доставки</label>
                        <input
                            id="delivery_address"
                            type="text"
                            name="delivery_address"
                            value="{{ old('delivery_address', auth()->user()->default_address) }}"
                            required
                        >
                    </div>

                    <div class="form-group">
                        <label for="customer_phone">Телефон</label>
                        <input
                            id="customer_phone"
                            type="text"
                            name="customer_phone"
                            value="{{ old('customer_phone', auth()->user()->phone) }}"
                            required
                        >
                    </div>

                    <div class="form-group">
                        <label for="comment">Комментарий курьеру</label>
                        <textarea id="comment" name="comment">{{ old('comment') }}</textarea>
                    </div>

                    <button class="btn btn-orange" type="submit" style="width: 100%;">Оформить заказ</button>
                </form>
            </aside>
        </section>
    @endif
@endsection
