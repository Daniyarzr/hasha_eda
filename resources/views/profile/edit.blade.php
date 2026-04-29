@extends('layouts.app')

@section('title', 'Профиль — Наша Еда')

@section('content')
    <section class="page-head" style="margin-top: 0;">
        <h1 class="headline" style="font-size: clamp(28px, 5vw, 40px);">Профиль</h1>
    </section>

    <div style="max-width: 900px; margin: 0 auto; display: grid; gap: 16px;">
        <section class="card">
            @include('profile.partials.update-profile-information-form')
        </section>

        <section class="card">
            @include('profile.partials.update-password-form')
        </section>

        <section class="card">
            @include('profile.partials.delete-user-form')
        </section>
    </div>
@endsection
