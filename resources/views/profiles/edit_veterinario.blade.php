@extends('layouts.app')

@section('panel-title', 'Mi Perfil')

@section('content')
<div class="premium-dashboard-container">
    @include('partials.vet_sidebar')

    <main class="dashboard-main-panel">
        @include('profiles.partials.profile_content')
    </main>
</div>
@endsection
