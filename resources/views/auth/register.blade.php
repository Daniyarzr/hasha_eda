@extends('layouts.app')

@section('title', 'Регистрация — Наша Еда')

@section('content')
    <section class="card" style="max-width: 560px; margin: 0 auto;">
        <h1 class="headline" style="font-size: 34px;">Создание аккаунта</h1>
        <p class="muted" style="margin-top: 8px;">Регистрация займет меньше минуты. После входа сможете оформлять заказы и сохранять адрес.</p>

        <form method="POST" action="{{ route('register') }}" style="margin-top: 16px;">
            @csrf

            <div class="form-grid form-grid-2">
                <div class="form-group form-span-2">
                    <label for="name">Имя</label>
                    <input id="name" type="text" name="name" required value="{{ old('name') }}">
                </div>

                <div class="form-group form-span-2">
                    <label for="email">Email</label>
                    <input id="email" type="email" name="email" required value="{{ old('email') }}">
                </div>

                <div class="form-group">
                    <label for="password">Пароль</label>
                    <input id="password" type="password" name="password" required>
                </div>

                <div class="form-group">
                    <label for="password_confirmation">Повторите пароль</label>
                    <input id="password_confirmation" type="password" name="password_confirmation" required>
                </div>
            </div>

            <div class="actions-row">
                <button class="btn btn-primary" type="submit">Зарегистрироваться</button>
                <a class="btn btn-ghost" href="{{ route('login') }}">Уже есть аккаунт</a>
            </div>
        </form>
    </section>
@endsection
