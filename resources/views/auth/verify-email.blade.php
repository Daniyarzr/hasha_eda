@extends('layouts.app')

@section('title', 'Подтверждение email — Наша Еда')

@section('content')
    <section class="card" style="max-width: 620px; margin: 0 auto;">
        <h1 class="headline" style="font-size: 32px;">Подтвердите email</h1>
        <p class="muted" style="margin-top: 8px;">
            Мы отправили письмо со ссылкой подтверждения. Если письма нет, отправьте его повторно.
        </p>

        @if (session('status') === 'verification-link-sent')
            <div class="alert alert-success" style="margin-top: 12px;">
                Новая ссылка подтверждения отправлена.
            </div>
        @endif

        <div class="actions-row" style="margin-top: 16px;">
            <form method="POST" action="{{ route('verification.send') }}">
                @csrf
                <button class="btn btn-primary" type="submit">Отправить письмо снова</button>
            </form>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button class="btn btn-ghost" type="submit">Выйти</button>
            </form>
        </div>
    </section>
@endsection
