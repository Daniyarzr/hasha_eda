@extends('layouts.app')

@section('title', 'Редактирование ресторана — админка')

@section('content')
    <section class="page-head" style="margin-top: 0;">
        <h1 class="headline" style="font-size: clamp(28px, 5vw, 40px);">Редактирование ресторана</h1>
    </section>

    <div class="admin-layout">
        @include('admin._nav')

        <div class="admin-main">
            @include('admin.restaurants._form', [
                'action' => route('admin.restaurants.update', $restaurant),
                'method' => 'PUT',
                'submitLabel' => 'Обновить ресторан',
            ])
        </div>
    </div>
@endsection
