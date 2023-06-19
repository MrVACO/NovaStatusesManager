<?php

namespace MrVaco\NovaStatusesManager;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Laravel\Nova\Events\ServingNova;
use Laravel\Nova\Http\Middleware\Authenticate;
use Laravel\Nova\Nova;
use MrVaco\NovaStatusesManager\Http\Middleware\Authorize;
use MrVaco\NovaStatusesManager\Models\Statuses;
use MrVaco\NovaStatusesManager\Nova\StatusesListResource;
use MrVaco\NovaStatusesManager\Nova\StatusesResource;
use MrVaco\NovaStatusesManager\Observers\StatusesObserver;

class ToolServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(): void
    {
        $this->app->booted(function()
        {
            $this->routes();
        });
        
        Nova::serving(function(ServingNova $event)
        {
            Nova::tools([
                new NovaStatusesManager
            ]);
        });
        
        Statuses::observe(StatusesObserver::class);
    }
    
    /**
     * Register the tool's routes.
     *
     * @return void
     */
    protected function routes(): void
    {
        if ($this->app->routesAreCached())
        {
            return;
        }
        
        Nova::router(['nova', Authenticate::class, Authorize::class], 'nova-statuses-manager')
            ->group(__DIR__ . '/../routes/inertia.php');
        
        Route::middleware(['nova', Authorize::class])
            ->prefix('nova-vendor/nova-statuses-manager')
            ->group(__DIR__ . '/../routes/api.php');
    }
    
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register(): void
    {
        Nova::resources([
            StatusesResource::class,
            StatusesListResource::class
        ]);
    }
}
