@extends('layouts.app')

@section('title', 'Восстановление пароля — Наша Еда')

@section('content')
    <section class="card" style="max-width: 560px; margin: 0 auto;">
        <h1 class="headline" style="font-size: 32px;">Восстановление пароля</h1>
        <p class="muted" style="margin-top: 8px;">
            Введите email, и мы отправим ссылку для сброса пароля.
        </p>

        @if (session('status'))
            <div class="alert alert-success" style="margin-top: 12px;">{{ session('status') }}</div>
        @endif

        <form method="POST" action="{{ route('password.email') }}" style="margin-top: 16px;">
            @csrf

            <div class="form-group">
                <label for="email">Email</label>
                <input
                    id="email"
                    type="email"
                    name="email"
                    value="{{ old('email') }}"
                    required
                    autofocus
                >
                @error('email')
                    <small class="help" style="color: #b91c1c;">{{ $message }}</small>
                @enderror
            </div>

            <div class="actions-row">
                <button class="btn btn-primary" type="submit">Отправить ссылку</button>
                <a class="btn btn-ghost" href="{{ route('login') }}">Назад ко входу</a>
            </div>
        </form>
    </section>
@endsection
