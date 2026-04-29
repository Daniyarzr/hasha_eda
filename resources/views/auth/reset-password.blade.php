@extends('layouts.app')

@section('title', 'Сброс пароля — Наша Еда')

@section('content')
    <section class="card" style="max-width: 560px; margin: 0 auto;">
        <h1 class="headline" style="font-size: 32px;">Сброс пароля</h1>

        <form method="POST" action="{{ route('password.store') }}" style="margin-top: 16px;">
            @csrf

            <input type="hidden" name="token" value="{{ $request->route('token') }}">

            <div class="form-group">
                <label for="email">Email</label>
                <input
                    id="email"
                    type="email"
                    name="email"
                    value="{{ old('email', $request->email) }}"
                    required
                    autofocus
                    autocomplete="username"
                >
                @error('email')
                    <small class="help" style="color: #b91c1c;">{{ $message }}</small>
                @enderror
            </div>

            <div class="form-group">
                <label for="password">Новый пароль</label>
                <input
                    id="password"
                    type="password"
                    name="password"
                    required
                    autocomplete="new-password"
                >
                @error('password')
                    <small class="help" style="color: #b91c1c;">{{ $message }}</small>
                @enderror
            </div>

            <div class="form-group">
                <label for="password_confirmation">Подтверждение пароля</label>
                <input
                    id="password_confirmation"
                    type="password"
                    name="password_confirmation"
                    required
                    autocomplete="new-password"
                >
                @error('password_confirmation')
                    <small class="help" style="color: #b91c1c;">{{ $message }}</small>
                @enderror
            </div>

            <div class="actions-row">
                <button class="btn btn-primary" type="submit">Сохранить новый пароль</button>
                <a class="btn btn-ghost" href="{{ route('login') }}">Ко входу</a>
            </div>
        </form>
    </section>
@endsection
