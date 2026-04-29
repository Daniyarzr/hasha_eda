@extends('layouts.app')

@section('title', 'Подтверждение пароля — Наша Еда')

@section('content')
    <section class="card" style="max-width: 560px; margin: 0 auto;">
        <h1 class="headline" style="font-size: 32px;">Подтверждение пароля</h1>
        <p class="muted" style="margin-top: 8px;">
            Это защищенная зона. Подтвердите пароль для продолжения.
        </p>

        <form method="POST" action="{{ route('password.confirm') }}" style="margin-top: 16px;">
            @csrf

            <div class="form-group">
                <label for="password">Пароль</label>
                <input
                    id="password"
                    type="password"
                    name="password"
                    required
                    autocomplete="current-password"
                >
                @error('password')
                    <small class="help" style="color: #b91c1c;">{{ $message }}</small>
                @enderror
            </div>

            <div class="actions-row">
                <button class="btn btn-primary" type="submit">Подтвердить</button>
                <a class="btn btn-ghost" href="{{ route('home') }}">На главную</a>
            </div>
        </form>
    </section>
@endsection
