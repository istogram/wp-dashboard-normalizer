<?php

namespace istogram\WpDashboardNormalizer\Providers;

use Illuminate\Support\ServiceProvider;
use istogram\WpDashboardNormalizer\Normalizer;

class NormalizerServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('Normalizer', function () {
            return new Normalizer($this->app);
        });

        $this->mergeConfigFrom(
            __DIR__.'/../../config/normalizer.php',
            'normalizer'
        );
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__.'/../../config/normalizer.php' => $this->app->configPath('normalizer.php'),
        ], 'config');

        $this->app->make('Normalizer');
    }
}
