@extends('layouts.app')

@section('title', 'Новый заказ — админка')

@section('content')
    <section class="page-head" style="margin-top: 0;">
        <h1 class="headline" style="font-size: clamp(28px, 5vw, 40px);">Новый заказ</h1>
    </section>

    <div class="admin-layout">
        @include('admin._nav')

        <div class="admin-main">
            @include('admin.orders._form', [
                'action' => route('admin.orders.store'),
                'submitLabel' => 'Сохранить заказ',
            ])
        </div>
    </div>
@endsection
