<?php

namespace Wnx\LaravelStats\Statistics;

class CodeTestRatio
{
    protected $project;

    public function __construct(ProjectStatistics $projectStatistics)
    {
        $this->project = $projectStatistics;
    }

    public function getRatio()
    {
        return round($this->getTestLoc() / $this->getCodeLoc(), 1);
    }

    public function getTestLoc()
    {
        return collect($this->project->components())
            ->filter(function($_, $key) {
                return str_contains($key, 'Test');
            })
            ->sum('loc');
    }

    public function getCodeLoc()
    {
        return collect($this->project->components())
            ->filter(function($_, $key) {
                return ! str_contains($key, 'Test');
            })
            ->sum('loc');
    }

}
