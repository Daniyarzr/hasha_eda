@extends('layouts.app')

@section('title', 'Редактирование блюда — админка')

@section('content')
    <section class="page-head" style="margin-top: 0;">
        <h1 class="headline" style="font-size: clamp(28px, 5vw, 40px);">Редактирование блюда</h1>
    </section>

    <div class="admin-layout">
        @include('admin._nav')

        <div class="admin-main">
            @include('admin.dishes._form', [
                'action' => route('admin.dishes.update', $dish),
                'method' => 'PUT',
                'submitLabel' => 'Обновить блюдо',
            ])
        </div>
    </div>
@endsection
