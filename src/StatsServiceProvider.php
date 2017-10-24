<?php

namespace Wnx\LaravelStats;

use Illuminate\Support\ServiceProvider;

class StatsServiceProvider extends ServiceProvider
{
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../config/stats.php' => config_path('stats.php'),
            ], 'config');
        }
    }

    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/stats.php', 'stats');

        $this->commands([
            StatsListCommand::class,
        ]);
    }
}
