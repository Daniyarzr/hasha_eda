@extends('layouts.app')

@section('title', 'Редактирование заказа — админка')

@section('content')
    <section class="page-head" style="margin-top: 0;">
        <h1 class="headline" style="font-size: clamp(28px, 5vw, 40px);">Редактирование заказа #{{ $order->id }}</h1>
    </section>

    <div class="admin-layout">
        @include('admin._nav')

        <div class="admin-main">
            @include('admin.orders._form', [
                'action' => route('admin.orders.update', $order),
                'method' => 'PUT',
                'submitLabel' => 'Обновить заказ',
            ])
        </div>
    </div>
@endsection
