@php
    $isEdit = isset($method);
@endphp

<form method="POST" action="{{ $action }}" class="card">
    @csrf
    @isset($method)
        @method($method)
    @endisset

    <div class="form-grid form-grid-2">
        <div class="form-group">
            <label for="name">Имя</label>
            <input id="name" type="text" name="name" required value="{{ old('name', $user->name) }}">
        </div>

        <div class="form-group">
            <label for="email">E-mail</label>
            <input id="email" type="email" name="email" required value="{{ old('email', $user->email) }}">
        </div>

        <div class="form-group">
            <label for="phone">Телефон</label>
            <input id="phone" type="text" name="phone" value="{{ old('phone', $user->phone) }}" placeholder="+7 (900) 000-00-00">
        </div>

        <div class="form-group">
            <label for="default_address">Адрес по умолчанию</label>
            <input id="default_address" type="text" name="default_address" value="{{ old('default_address', $user->default_address) }}">
        </div>

        <div class="form-group">
            <label for="password">Пароль {{ $isEdit ? '(необязательно)' : '' }}</label>
            <input id="password" type="password" name="password" {{ $isEdit ? '' : 'required' }}>
            <small class="help">
                @if($isEdit)
                    Оставьте пустым, чтобы сохранить текущий пароль.
                @else
                    Минимальные требования к паролю применяются автоматически.
                @endif
            </small>
        </div>

        <div class="form-group">
            <label for="password_confirmation">Подтверждение пароля</label>
            <input id="password_confirmation" type="password" name="password_confirmation" {{ $isEdit ? '' : 'required' }}>
        </div>

        <div class="form-group form-span-2">
            <label class="checkbox-field">
                <input type="checkbox" name="is_admin" value="1" @checked((bool) old('is_admin', $user->is_admin ?? false))>
                Выдать права администратора
            </label>
        </div>
    </div>

    <div class="actions-row">
        <button type="submit" class="btn btn-primary">{{ $submitLabel }}</button>
        <a href="{{ route('admin.users.index') }}" class="btn btn-ghost">Отмена</a>
    </div>
</form>

