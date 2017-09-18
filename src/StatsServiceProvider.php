<?php

namespace Wnx\LaravelStats;

use Illuminate\Support\ServiceProvider;
use Wnx\LaravelStats\Commands\StatsListCommand;

class StatsServiceProvider extends ServiceProvider
{
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../config/laravel-stats.php' => config_path('laravel-stats.php'),
            ], 'config');
        }
    }

    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/laravel-stats.php', 'laravel-stats');


        $this->app->bind('command.stats:stats-list', StatsListCommand::class);

        $this->commands([
            'command.stats:stats-list'
        ]);
    }


}
