<?php

namespace App\Vendor\Locale;

use Illuminate\Support\ServiceProvider;

class LocalizationSeoServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot()
    {
        // $configPath = __DIR__ . '/config/config_seo.php';
        // $this->mergeConfigFrom($configPath, 'config_seo');
        // $this->publishes([$configPath => config_path('config_seo.php')], 'config');

        $this->publishes([
            __DIR__.'/config/config.php' => config_path('localizationseo.php'),
        ], 'config');
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['modules.handler', 'modules'];
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $packageConfigFile = __DIR__.'/config/config_seo.php';

        $this->mergeConfigFrom(
            $packageConfigFile, 'localizationseo'
        );

        $this->registerBindings();

        $this->registerCommands();
    }

    protected function registerBindings()
    {
        $this->app->singleton(LocalizationSeo::class, function () {
            return new LocalizationSeo();
        });

        $this->app->alias(LocalizationSeo::class, 'localizationseo');
    }

    /**
     * Registers route caching commands.
     */
    protected function registerCommands()
    {
        $this->app->singleton('localizationseoroutecache.cache', Commands\RouteTranslationsCacheCommand::class);
        $this->app->singleton('localizationseoroutecache.clear', Commands\RouteTranslationsClearCommand::class);
        $this->app->singleton('localizationseoroutecache.list', Commands\RouteTranslationsListCommand::class);

        $this->commands([
            'localizationseoroutecache.cache',
            'localizationseoroutecache.clear',
            'localizationseoroutecache.list',
        ]);
    }
}
