@extends('layouts.app')

@section('title', 'Админка: пользователи')

@section('content')
    <section class="page-head" style="margin-top: 0;">
        <h1 class="headline" style="font-size: clamp(28px, 5vw, 40px);">Пользователи</h1>
        <a href="{{ route('admin.users.create') }}" class="btn btn-primary">Добавить пользователя</a>
    </section>

    <div class="admin-layout">
        @include('admin._nav')

        <div class="admin-main">
            @if($users->isEmpty())
                <div class="empty">Пользователи не найдены.</div>
            @else
                <section class="table-card">
                    <div class="table-wrap">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Имя</th>
                                    <th>E-mail</th>
                                    <th>Телефон</th>
                                    <th>Заказов</th>
                                    <th>Роль</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($users as $user)
                                    <tr>
                                        <td>{{ $user->id }}</td>
                                        <td>{{ $user->name }}</td>
                                        <td>{{ $user->email }}</td>
                                        <td>{{ $user->phone ?: '—' }}</td>
                                        <td>{{ $user->orders_count }}</td>
                                        <td>
                                            @if($user->is_admin)
                                                <span class="badge-status status-processing">Администратор</span>
                                            @else
                                                <span class="badge-status status-new">Пользователь</span>
                                            @endif
                                        </td>
                                        <td class="table-actions">
                                            <a class="btn btn-ghost" href="{{ route('admin.users.show', $user) }}">Открыть</a>
                                            <a class="btn btn-ghost" href="{{ route('admin.users.edit', $user) }}">Изменить</a>
                                            <form method="POST" action="{{ route('admin.users.destroy', $user) }}" onsubmit="return confirm('Удалить пользователя?')">
                                                @csrf
                                                @method('DELETE')
                                                <button class="btn btn-danger" type="submit" @disabled(auth()->id() === $user->id)>Удалить</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </section>
            @endif
        </div>
    </div>
@endsection
