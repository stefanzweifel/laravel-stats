<?php declare(strict_types=1);

namespace Wnx\LaravelStats\Tests\ShareableMetrics\Metrics;

use Wnx\LaravelStats\ShareableMetrics\Metrics\ModelsMassAssignment;
use Wnx\LaravelStats\Tests\Stubs\Models\Group;
use Wnx\LaravelStats\Tests\Stubs\Models\Post;
use Wnx\LaravelStats\Tests\Stubs\Models\User;
use Wnx\LaravelStats\Tests\TestCase;

class ModelsMassAssignmentTest extends TestCase
{
    /** @test */
    public function it_returns_correct_metric_name()
    {
        $project = $this->createProjectFromClasses([]);

        $metric = new ModelsMassAssignment($project);

        $this->assertEquals('models_mass_assignment', $metric->name());
    }

    /** @test */
    public function it_returns_an_empty_array_if_project_does_not_contain_models()
    {
        $project = $this->createProjectFromClasses([]);

        $metric = new ModelsMassAssignment($project);

        $this->assertEquals([], $metric->value());
    }

    /** @test */
    public function it_returns_the_number_of_guarded_and_unguarded_models_in_the_return_array()
    {
        $project = $this->createProjectFromClasses([
            User::class,
            Post::class,
            Group::class
        ]);

        $metric = new ModelsMassAssignment($project);

        $this->assertEquals([
            'guarded' => 1,
            'fillable' => 1,
        ], $metric->value());
    }
}
