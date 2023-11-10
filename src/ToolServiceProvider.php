<?php

namespace MrVaco\NovaStatusesManager;

use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Lang;
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
            
            Nova::script('status-field', __DIR__ . '/../dist/js/status-field.js');
        });
        
        Statuses::observe(StatusesObserver::class);
        Lang::addJsonPath(__DIR__ . '/../resources/lang');
        
        $this->forPublish();
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
    
    protected function forPublish()
    {
        if (!$this->app->runningInConsole())
        {
            return;
        }
        
        $this->publishes([
            __DIR__ . '/../database/migrations/create_statuses_table.stub'       => $this->getMigrationFileName('create_statuses_table.php'),
            __DIR__ . '/../database/migrations/create_statuses_lists_table.stub' => $this->getMigrationFileName('create_statuses_lists_table.php'),
            __DIR__ . '/../database/migrations/fill_statuses_table.stub'         => $this->getMigrationFileName('fill_statuses_table.php'),
        ], 'mr_vaco__statuses');
    }
    
    /**
     * Returns existing migration file if found, else uses the current timestamp.
     */
    protected function getMigrationFileName(string $migrationFileName): string
    {
        $timestamp = date('Y_m_d_His');
        
        $filesystem = $this->app->make(Filesystem::class);
        
        return Collection::make([database_path('migrations/')])
            ->flatMap(fn($path) => $filesystem->glob($path . '*_' . $migrationFileName))
            ->push(database_path("/migrations/{$timestamp}_{$migrationFileName}"))
            ->first();
    }
}
