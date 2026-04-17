@extends('layouts.app')

@section('title', 'Каталог ресторанов — Наша Еда')

@section('content')
    <section class="section-title" style="margin-top: 0;">
        <h1 class="headline" style="font-size: clamp(34px, 5vw, 52px);">Каталог ресторанов</h1>
    </section>

    @if($restaurants->isEmpty())
        <div class="empty">Сейчас нет активных ресторанов.</div>
    @else
        <section class="grid-3">
            @foreach($restaurants as $restaurant)
                <article class="card">
                    <div class="restaurant-media">
                        <img src="{{ asset(ltrim($restaurant->image_url, '/')) }}" alt="Логотип {{ $restaurant->name }}" loading="lazy">
                    </div>

                    <h2 class="headline" style="font-size: 26px;">{{ $restaurant->name }}</h2>
                    <p class="muted" style="margin-top: 8px;">{{ $restaurant->description }}</p>

                    <div class="meta-row">
                        <span class="pill">{{ $restaurant->cuisine }}</span>
                        <span class="pill">Рейтинг {{ number_format((float) $restaurant->rating, 1) }}/5</span>
                        <span class="pill">{{ $restaurant->delivery_time }} мин</span>
                        <span class="pill">Доставка {{ number_format((float) $restaurant->delivery_fee, 0) }} ₽</span>
                    </div>

                    <div class="actions-row">
                        <a class="btn btn-secondary" href="{{ route('restaurants.show', $restaurant->slug) }}">Смотреть меню</a>
                    </div>
                </article>
            @endforeach
        </section>
    @endif
@endsection
