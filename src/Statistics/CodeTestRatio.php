<?php

namespace Wnx\LaravelStats\Statistics;

class CodeTestRatio
{
    protected $project;

    public function __construct(ProjectStatistics $projectStatistics)
    {
        $this->project = $projectStatistics;
    }

    public function getRatio() : float
    {
        return round($this->getTestLoc() / $this->getCodeLoc(), 1);
    }

    public function getTestLoc() : int
    {
        return collect($this->project->components())
            ->filter(function($_, $key) {
                return str_contains($key, 'Test');
            })
            ->sum('loc');
    }

    public function getCodeLoc() : int
    {
        return collect($this->project->components())
            ->filter(function($_, $key) {
                return ! str_contains($key, 'Test');
            })
            ->sum('loc');
    }

}
