<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Compartir conteos de notificaciones con las vistas de administrador
        \Illuminate\Support\Facades\View::composer(['layouts.app', 'admin.dashboard'], function ($view) {
            $view->with('pendingVolunteersCount', \App\Models\Inscription::where('ins_tipo_rol', 'voluntario')->where('ins_estado', 'Pendiente')->count());
            $view->with('pendingVetsCount', \App\Models\Inscription::where('ins_tipo_rol', 'veterinario')->where('ins_estado', 'Pendiente')->count());
            $view->with('pendingAdoptionsCount', \App\Models\AdoptionRequest::where('Soli_estado', 'Pendiente')->count());
        });
    }
}
