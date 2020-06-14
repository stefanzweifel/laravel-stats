<?php declare(strict_types=1);

namespace Wnx\LaravelStats\Metrics\AvailableMetrics;

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
            'type' => $this->type(),
            'name' => $this->name(),
            'value' => $this->value(),
        ];
    }
}
