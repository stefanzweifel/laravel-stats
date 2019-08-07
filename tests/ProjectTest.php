<?php

namespace Wnx\LaravelStats\Tests;

use Illuminate\Support\Facades\Gate;
use Wnx\LaravelStats\Project;
use Wnx\LaravelStats\ReflectionClass;
use Wnx\LaravelStats\Tests\Stubs\Models\Project as ProjectModel;
use Wnx\LaravelStats\Tests\Stubs\Policies\DemoPolicy;

class ProjectTest extends TestCase
{
    /** @test */
    public function creates_a_project_object_from_a_collection_of_reflection_classes()
    {
        $classes = collect([
            $projectModel = new ReflectionClass(ProjectModel::class),
        ]);

        $project = Project::fromReflectionClasses($classes);

        $this->assertTrue(
            $project->classes()->map(function ($class) {
                return $class->getReflectionClass();
            })->contains($projectModel)
        );
    }

    /** @test */
    public function groups_classes_into_components()
    {
        Gate::policy(\Wnx\LaravelStats\Tests\Stubs\Models\Project::class, \Wnx\LaravelStats\Tests\Stubs\Policies\DemoPolicy::class);

        $classes = collect([
            new ReflectionClass(DemoPolicy::class),
        ]);

        $project = Project::fromReflectionClasses($classes);

        // $groupedByName = $project->groupByComponentName();

        // $this->assertEquals('Policies', $groupedByName->keys()[0]);
    }

    /** @test */
    public function groups_components_into_buckets()
    {
        // groups components into buckets
    }

    /** @test */
    public function calculates_total_numbers_for_stats_for_classes()
    {
        // calculates total numbers for stats for classes
    }

    /** @test */
    public function calculates_code_to_test_ratio_for_the_project()
    {
        // calculates code to test ratio for classes
    }

    /** @test */
    public function calculates_number_of_routes_for_the_project()
    {
        // calculates number of routes for a project
    }
}
