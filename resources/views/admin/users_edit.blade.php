@extends('layouts.app')

@section('title', 'Редактирование пользователя — админка')

@section('content')
    <section class="page-head" style="margin-top: 0;">
        <h1 class="headline" style="font-size: clamp(28px, 5vw, 40px);">Редактирование пользователя</h1>
    </section>

    <div class="admin-layout">
        @include('admin._nav')

        <div class="admin-main">
            @include('admin.users_form', [
                'action' => route('admin.users.update', $user),
                'method' => 'PUT',
                'submitLabel' => 'Обновить пользователя',
            ])
        </div>
    </div>
@endsection
