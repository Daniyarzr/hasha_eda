@extends('layouts.app')

@section('title', 'Новый пользователь — админка')

@section('content')
    <section class="page-head" style="margin-top: 0;">
        <h1 class="headline" style="font-size: clamp(28px, 5vw, 40px);">Новый пользователь</h1>
    </section>

    <div class="admin-layout">
        @include('admin._nav')

        <div class="admin-main">
            @include('admin.users_form', [
                'action' => route('admin.users.store'),
                'submitLabel' => 'Сохранить пользователя',
            ])
        </div>
    </div>
@endsection
