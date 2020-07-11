<?php declare(strict_types=1);

namespace Wnx\LaravelStats\Tests\ShareableMetrics\Metrics;

use Wnx\LaravelStats\ShareableMetrics\Metrics\ModelsFolder;
use Wnx\LaravelStats\Tests\Stubs\Models\User;
use Wnx\LaravelStats\Tests\TestCase;

class ModelsFolderTest extends TestCase
{
    /** @test */
    public function it_returns_correct_metric_name()
    {
        $project = $this->createProjectFromClasses([]);

        $metric = new ModelsFolder($project);

        $this->assertEquals('models_folder', $metric->name());
    }

    /** @test */
    public function it_returns_null_if_no_models_are_found_in_the_project()
    {
        $project = $this->createProjectFromClasses([
            //
        ]);

        $metric = new ModelsFolder($project);

        $this->assertNull($metric->value());
    }
    
    /** @test */
    public function it_returns_true_if_models_are_stored_in_non_default_namespace()
    {
        $project = $this->createProjectFromClasses([
            User::class,
        ]);

        $metric = new ModelsFolder($project);

        $this->assertTrue($metric->value());
    }
}
