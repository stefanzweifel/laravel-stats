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
                __DIR__.'/../config/stats.php' => config_path('stats.php'),
            ], 'config');
        }
    }

    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/stats.php', 'stats');

        $this->app->bind('command.stats:stats-list', StatsListCommand::class);

        $this->commands([
            'command.stats:stats-list',
        ]);
    }
}
