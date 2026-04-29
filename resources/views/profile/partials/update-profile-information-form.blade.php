<section>
    <header>
        <h2 class="headline" style="font-size: 24px;">Профиль</h2>
        <p class="muted" style="margin-top: 8px;">
            Изменение имени и email.
        </p>
    </header>

    <form id="send-verification" method="POST" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="POST" action="{{ route('profile.update') }}" style="margin-top: 16px;">
        @csrf
        @method('PATCH')

        <div class="form-group">
            <label for="name">Имя</label>
            <input id="name" name="name" type="text" value="{{ old('name', $user->name) }}" required autofocus autocomplete="name">
            @error('name')
                <small class="help" style="color: #b91c1c;">{{ $message }}</small>
            @enderror
        </div>

        <div class="form-group">
            <label for="email">Email</label>
            <input id="email" name="email" type="email" value="{{ old('email', $user->email) }}" required autocomplete="username">
            @error('email')
                <small class="help" style="color: #b91c1c;">{{ $message }}</small>
            @enderror

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <p class="muted" style="margin-top: 8px;">
                    Email не подтвержден.
                    <button form="send-verification" type="submit" class="btn btn-ghost" style="margin-left: 8px;">
                        Отправить письмо подтверждения
                    </button>
                </p>

                @if (session('status') === 'verification-link-sent')
                    <p class="alert alert-success" style="margin-top: 8px;">
                        Новая ссылка подтверждения отправлена.
                    </p>
                @endif
            @endif
        </div>

        <div class="actions-row">
            <button class="btn btn-primary" type="submit">Сохранить</button>

            @if (session('status') === 'profile-updated')
                <span class="muted">Сохранено</span>
            @endif
        </div>
    </form>
</section>
