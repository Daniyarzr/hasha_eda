@extends('layouts.app')

@section('title', 'Новый ресторан — админка')

@section('content')
    <section class="page-head" style="margin-top: 0;">
        <h1 class="headline" style="font-size: clamp(28px, 5vw, 40px);">Новый ресторан</h1>
    </section>

    <div class="admin-layout">
        @include('admin._nav')

        <div class="admin-main">
            @include('admin.restaurants._form', [
                'action' => route('admin.restaurants.store'),
                'submitLabel' => 'Сохранить ресторан',
            ])
        </div>
    </div>
@endsection
