@extends('layouts.app')

@section('title', 'Редактирование категории — админка')

@section('content')
    <section class="page-head" style="margin-top: 0;">
        <h1 class="headline" style="font-size: clamp(28px, 5vw, 40px);">Редактирование категории</h1>
    </section>

    @include('admin._nav')

    @include('admin.categories._form', [
        'action' => route('admin.categories.update', $category),
        'method' => 'PUT',
        'submitLabel' => 'Обновить категорию',
    ])
@endsection
