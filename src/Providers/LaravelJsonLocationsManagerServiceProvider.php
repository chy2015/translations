<?php namespace Chy2015\Translations\Providers;

use Chy2015\Translations\Commands\SearchCommand;
use Illuminate\Support\ServiceProvider;
use Chy2015\Translations\Services\Helper;

use Chy2015\Translations\Commands\InstallCommand;
use Chy2015\Translations\Commands\PublishAllCommand;

class LaravelJsonLocationsManagerServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot()
    {
        \Config::set('database.connections.locations',
                    config('lang-manager.connections.locations'));

        /*Load views*/
        $this->loadViewsFrom(__DIR__ . '/../views', 'langs');
        /*Load routes*/
        $this->loadRoutesFrom(__DIR__.'/../routes/web.php');

        $this->publishes([
            __DIR__ . '/../config/location.php' => base_path('config/location.php'),
        ], 'location');

        $this->publishes([
            __DIR__ . '/../views' => base_path('/resources/views/vendor/langs')], 'views');
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        //Load helpers
        Helper::loadModuleHelpers(__DIR__);
        $this->mergeConfigFrom(__DIR__.'/../config/database.php','lang-manager');
        $this->mergeConfigFrom(__DIR__.'/../config/location.php', 'location');

        $this->commands($this->commands);
    }

    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        InstallCommand::class,
        PublishAllCommand::class,
        SearchCommand::class,

    ];
}
