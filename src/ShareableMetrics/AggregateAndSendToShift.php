<?php

namespace Wnx\LaravelStats\ShareableMetrics;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Wnx\LaravelStats\Classifier;
use Wnx\LaravelStats\Classifiers\Testing\PhpUnitClassifier;
use Wnx\LaravelStats\Project;
use Wnx\LaravelStats\ShareableMetrics\Metrics\NumberOfPackages;
use Wnx\LaravelStats\ShareableMetrics\Metrics\NumberOfRelationships;
use Wnx\LaravelStats\ShareableMetrics\Metrics\NumberOfRoutes;
use Wnx\LaravelStats\ShareableMetrics\Metrics\ProjectLinesOfCode;
use Wnx\LaravelStats\ShareableMetrics\Metrics\ProjectLogicalLinesOfCode;
use Wnx\LaravelStats\ShareableMetrics\Metrics\ProjectNumberOfClasses;
use Wnx\LaravelStats\ValueObjects\Component;

class AggregateAndSendToShift
{
    public function fire(Project $project)
    {

        $metrics = app(CollectMetrics::class)->get($project);

        dd($metrics);

        app(SendToLaravelShift::class)->send($metrics);
    }

}
