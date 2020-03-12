<?php

namespace Bugphix\BugphixLaravel;

use Illuminate\Support\ServiceProvider;
use Illuminate\Foundation\AliasLoader;
use Bugphix\BugphixLaravel\Facades\Bugphix as BugphixFacade;
use Route;
use Log;

class BugphixServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    protected $defaultAdminSlug = 'bugphix';

    public function register()
    {

        // Register Bugphix as global Facade class
        $loader = AliasLoader::getInstance();
        $loader->alias('Bugphix', BugphixFacade::class);
        $this->app->singleton('bugphix', function () {
            return new Bugphix();
        });

        if ($this->app->runningInConsole()) {
            $this->bugphixPublishable();
            $this->bugphixCommands();
        }
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadMigrationsFrom(__DIR__ . '/Migrations');
        $this->loadViewsFrom(__DIR__ . '/Resources/views', 'bugphix');
        $this->registerRoutes();
    }

    protected function registerRoutes()
    {
        // DSN API route
        if (!in_array(config('bugphix.option.dsn_slug'), ['', '/'])) {
            $this->loadRoutesFrom(__DIR__ . "/Routes/dsn.php");
        }

        // if has no valid dsn entered
        if (!filter_var(config('bugphix.dsn'), FILTER_VALIDATE_URL) && config('bugphix.dashboard.enable') === true) {
            Route::group($this->routeConfig(), function () {
                $route = $this->isRouteProtected()
                    ? 'web.php'
                    : 'disabled.php';

                $this->loadRoutesFrom(__DIR__ . "/Routes/{$route}");
            });
        }
    }

    private function isRouteProtected()
    {
        $prefix = $this->routeConfig()['prefix'] ?? $this->defaultAdminSlug;
        $middleware = array_diff( $this->routeConfig()['middleware'] ?? [], ['web','api'] ); // excluding web and api as middleware
        $isLocal = app()->environment('local');

        return $isLocal || count($middleware) || ($prefix !== $this->defaultAdminSlug);
    }

    /**
     * Publishable resources.
     */
    private function bugphixPublishable()
    {
        $path = dirname(__DIR__) . '/src/Publishable';

        $this->publishes([
            "{$path}/config/bugphix.php" => config_path('bugphix.php'),
        ], 'bugphix-config');
    }

    /**
     * Bugphix Commands
     */

    private function bugphixCommands()
    {
        $this->commands([
            Commands\InstallCommand::class,
            Commands\BugphixAssetsSymlink::class,
            Commands\BugphixTestCommand::class,
        ]);
    }

    private function routeConfig()
    {
        $prefix = !empty(config('bugphix.dashboard.url')) ? config('bugphix.dashboard.url') : $this->defaultAdminSlug;

        $configMiddleware = config('bugphix.dashboard.middleware') ?? [];

        if (!is_array($configMiddleware)) $configMiddleware = [$configMiddleware];

        $middleware = array_merge(['web'], $configMiddleware); // always attach web middleware

        return [
            'as' => 'bugphix.',
            'prefix' => $prefix,
            'middleware' => $middleware,
        ];
    }
}
