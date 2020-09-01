<?php declare(strict_types=1);

namespace Wnx\LaravelStats\ShareableMetrics\Metrics;

use Wnx\LaravelStats\Project;

abstract class Metric
{
    /**
     * @var Project
     */
    protected $project;

    public function __construct(Project $project)
    {
        $this->project = $project;
    }

    public function toArray()
    {
        return [
            $this->name() => $this->value()
        ];
    }
}
