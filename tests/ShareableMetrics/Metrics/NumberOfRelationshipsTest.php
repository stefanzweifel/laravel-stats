<?php

namespace Wnx\LaravelStats\Tests\ShareableMetrics\Metrics;

use Wnx\LaravelStats\Project;
use Wnx\LaravelStats\ShareableMetrics\Metrics\NumberOfRelationships;
use Wnx\LaravelStats\Tests\Stubs\Models\Group;
use Wnx\LaravelStats\Tests\Stubs\Models\Post;
use Wnx\LaravelStats\Tests\Stubs\Models\User;
use Wnx\LaravelStats\Tests\TestCase;

class NumberOfRelationshipsTest extends TestCase
{
    /** @test */
    public function it_returns_correct_metric_name()
    {
        $project = $this->createProjectFromClasses([]);

        $metric = new NumberOfRelationships($project);

        $this->assertEquals('project_number_of_relationships', $metric->name());
    }

    /** @test */
    public function it_returns_0_if_no_relationships_could_be_found_for_a_given_project()
    {
        $project = $this->createProjectFromClasses([]);

        $metric = new NumberOfRelationships($project);

        $this->assertEquals(0, $metric->value());
    }

    /** @test */
    public function it_returns_correct_number_of_relationships_in_a_project_for_a_given_project()
    {
        $project = $this->createProjectFromClasses([
            User::class,
            Post::class,
            Group::class
        ]);

        $metric = new NumberOfRelationships($project);

        $this->assertEquals(5, $metric->value());
    }

}
