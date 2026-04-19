@extends('layouts.app')

@section('panel-title', 'Mi Perfil')

@section('content')
    <div class="admin-profile-wrapper" style="padding: 20px;">
        @include('profiles.partials.profile_content')
    </div>
@endsection

@section('styles')
<style>
    /* Estilos adicionales para mejorar la integración en el panel administrativo */
    .admin-profile-wrapper {
        min-height: calc(100vh - 160px);
        display: flex;
        flex-direction: column;
        justify-content: center;
    }
    
    .premium-btn {
        transition: all 0.3s ease !important;
    }
    
    .premium-btn:hover {
        background: #e2e8f0 !important;
        transform: translateX(-3px);
    }

    /* Ajuste de botones de pestañas para que combinen con el verde admin */
    .tab-btn.active {
        background: #2e8b57 !important;
        color: white !important;
        box-shadow: 0 4px 12px rgba(46, 139, 87, 0.2);
    }
</style>
@endsection
