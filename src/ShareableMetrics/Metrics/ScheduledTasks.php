<?php declare(strict_types=1);

namespace Wnx\LaravelStats\ShareableMetrics\Metrics;

use Illuminate\Console\Scheduling\Schedule;
use Wnx\LaravelStats\Contracts\CollectableMetric;

class ScheduledTasks extends Metric implements CollectableMetric
{
    public function name(): string
    {
        return 'scheduled_tasks';
    }

    public function value()
    {
        return count(app(Schedule::class)->events());
    }
}
