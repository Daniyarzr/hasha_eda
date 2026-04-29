<section class="space-y-6">
    <header>
        <h2 class="headline" style="font-size: 24px;">
            Удаление аккаунта
        </h2>

        <p class="muted" style="margin-top: 8px;">
            Действие необратимо. После удаления аккаунт и связанные данные будут удалены.
        </p>
    </header>

    <form method="POST" action="{{ route('profile.destroy') }}" onsubmit="return confirm('Удалить аккаунт без возможности восстановления?')">
        @csrf
        @method('DELETE')

        <div class="form-group">
            <label for="password">Введите пароль для подтверждения</label>
            <input id="password" name="password" type="password" required autocomplete="current-password">
            @foreach ($errors->userDeletion->get('password') as $message)
                <small class="help" style="color: #b91c1c;">{{ $message }}</small>
            @endforeach
        </div>

        <div class="actions-row">
            <button class="btn btn-ghost" type="button" onclick="window.location='{{ route('home') }}'">Отмена</button>
            <button class="btn btn-primary" type="submit" style="background:#b91c1c; border-color:#b91c1c;">Удалить аккаунт</button>
        </div>
    </form>
</section>
