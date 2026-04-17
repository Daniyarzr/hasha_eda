@extends('layouts.app')

@section('title', 'Вход — Наша Еда')

@section('content')
    <section class="card" style="max-width: 520px; margin: 0 auto;">
        <h1 class="headline" style="font-size: 36px;">Вход в аккаунт</h1>
        <p class="muted" style="margin-top: 8px;">Войдите, чтобы пользоваться корзиной, оформлять заказы и видеть историю.</p>

        <form method="POST" action="{{ route('login') }}" style="margin-top: 16px;">
            @csrf

            <div class="form-group">
                <label for="email">Email</label>
                <input id="email" type="email" name="email" required value="{{ old('email') }}">
            </div>

            <div class="form-group">
                <label for="password">Пароль</label>
                <input id="password" type="password" name="password" required>
            </div>

            <div class="form-group">
                <label style="display:flex; align-items:center; gap:8px; font-weight:600;">
                    <input type="checkbox" name="remember" value="1" style="width:auto;">
                    Запомнить меня
                </label>
            </div>

            <div class="actions-row">
                <button class="btn btn-primary" type="submit">Войти</button>
                <a class="btn btn-ghost" href="{{ route('register') }}">Создать аккаунт</a>
            </div>
        </form>
    </section>
@endsection
