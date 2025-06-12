<?php

namespace App\Providers;
use App\Services\Cita\Interfaces\CitaServiceInterface;
use App\Services\Cita\CitaService;
use App\Services\Categoria\CategoriaService;
use App\Services\Categoria\Interfaces\CategoriaServiceInterface;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use Symfony\Component\HttpFoundation\Request as SymfonyRequest;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(CitaServiceInterface::class, CitaService::class);
        $this->app->bind(CategoriaServiceInterface::class, CategoriaService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(Request $request): void
    {
        if ($this->app->environment('production')) {
        $request->setTrustedProxies(
                [$request->getClientIp()],
                SymfonyRequest::HEADER_X_FORWARDED_FOR |
                SymfonyRequest::HEADER_X_FORWARDED_HOST |
                SymfonyRequest::HEADER_X_FORWARDED_PORT |
                SymfonyRequest::HEADER_X_FORWARDED_PROTO
            );

            URL::forceScheme('https');
        }
    }
}
