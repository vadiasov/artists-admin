<?php

namespace Vadiasov\ArtistsAdmin;

use Illuminate\Support\ServiceProvider;
use Illuminate\Routing\Router;

class ArtistsAdminServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot(Router $router)
    {
        $router->aliasMiddleware('artists', \Vadiasov\ArtistsAdmin\Middleware\ArtistsMiddleware::class);
        
        $this->publishes([
            __DIR__ . '/Config/artists.php' => config_path('artists.php'),
        ], 'artists_config');
        $this->publishes([
            __DIR__ . '/Views' => resource_path('views/vadiasov/admin/artists'),
        ]);
        $this->publishes([
            __DIR__ . '/Assets' => public_path('vadiasov/admin/artists'),
        ], 'artists_assets');
        
        $this->loadRoutesFrom(__DIR__ . '/Routes/web.php');
        $this->loadMigrationsFrom(__DIR__ . '/Migrations');
        $this->loadTranslationsFrom(__DIR__ . '/Translations', 'artists');
        $this->loadViewsFrom(__DIR__ . '/Views', 'artists-admin');
        
        $this->publishes([
            __DIR__ . '/Translations' => resource_path('lang/vendor/artists'),
            __DIR__ . '/Migrations' => database_path('migrations'),
            __DIR__ . '/Seeds' => database_path('seeds'),
        ]);
        
        if ($this->app->runningInConsole()) {
            $this->commands([
                \Vadiasov\ArtistsAdmin\Commands\ArtistsCommand::class,
            ]);
        }
    }
    
    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->make('Vadiasov\ArtistsAdmin\Controllers\ArtistsController');
        $this->app->make('Vadiasov\ArtistsAdmin\Requests\ArtistRequest');
        $this->mergeConfigFrom(
            __DIR__ . '/Config/artists.php', 'artists'
        );
    }
}
