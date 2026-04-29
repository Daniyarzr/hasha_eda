<section>
    <header>
        <h2 class="headline" style="font-size: 24px;">Смена пароля</h2>
        <p class="muted" style="margin-top: 8px;">
            Укажите текущий и новый пароль.
        </p>
    </header>

    <form method="POST" action="{{ route('password.update') }}" style="margin-top: 16px;">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="update_password_current_password">Текущий пароль</label>
            <input id="update_password_current_password" name="current_password" type="password" autocomplete="current-password">
            @foreach ($errors->updatePassword->get('current_password') as $message)
                <small class="help" style="color: #b91c1c;">{{ $message }}</small>
            @endforeach
        </div>

        <div class="form-group">
            <label for="update_password_password">Новый пароль</label>
            <input id="update_password_password" name="password" type="password" autocomplete="new-password">
            @foreach ($errors->updatePassword->get('password') as $message)
                <small class="help" style="color: #b91c1c;">{{ $message }}</small>
            @endforeach
        </div>

        <div class="form-group">
            <label for="update_password_password_confirmation">Подтверждение нового пароля</label>
            <input id="update_password_password_confirmation" name="password_confirmation" type="password" autocomplete="new-password">
            @foreach ($errors->updatePassword->get('password_confirmation') as $message)
                <small class="help" style="color: #b91c1c;">{{ $message }}</small>
            @endforeach
        </div>

        <div class="actions-row">
            <button class="btn btn-primary" type="submit">Сохранить пароль</button>
            @if (session('status') === 'password-updated')
                <span class="muted">Сохранено</span>
            @endif
        </div>
    </form>
</section>
