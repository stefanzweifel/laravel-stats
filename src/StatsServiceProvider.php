<?php declare(strict_types=1);

namespace Wnx\LaravelStats;

use Illuminate\Support\ServiceProvider;

class StatsServiceProvider extends ServiceProvider
{
    /**
     * @var string
     */
    private $config = __DIR__.'/../config/stats.php';

    /**
     * {@inheritDoc}
     */
    public function boot(): void
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                $this->config => base_path('config/stats.php'),
            ], 'config');
        }
    }

    /**
     * {@inheritDoc}
     */
    public function register(): void
    {
        $this->mergeConfigFrom($this->config, 'stats');

        $this->commands([
            StatsListCommand::class,
        ]);
    }
}
