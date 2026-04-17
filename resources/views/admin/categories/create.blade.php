@extends('layouts.app')

@section('title', 'Новая категория — админка')

@section('content')
    <section class="page-head" style="margin-top: 0;">
        <h1 class="headline" style="font-size: clamp(28px, 5vw, 40px);">Новая категория</h1>
    </section>

    @include('admin._nav')

    @include('admin.categories._form', [
        'action' => route('admin.categories.store'),
        'submitLabel' => 'Сохранить категорию',
    ])
@endsection
