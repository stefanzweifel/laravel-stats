<?php declare(strict_types=1);

namespace Wnx\LaravelStats\Tests\ShareableMetrics\Metrics;

use Wnx\LaravelStats\ShareableMetrics\Metrics\ModelsExtendOtherModel;
use Wnx\LaravelStats\Tests\Stubs\Models\Group;
use Wnx\LaravelStats\Tests\Stubs\Models\User;
use Wnx\LaravelStats\Tests\TestCase;

class ModelsExtendOtherModelTest extends TestCase
{
    /** @test */
    public function it_returns_correct_metric_name()
    {
        $project = $this->createProjectFromClasses([]);

        $metric = new ModelsExtendOtherModel($project);

        $this->assertEquals('models_extend_model', $metric->name());
    }

    /** @test */
    public function it_returns_null_if_no_models_are_found_in_the_project()
    {
        $project = $this->createProjectFromClasses([
            //
        ]);

        $metric = new ModelsExtendOtherModel($project);

        $this->assertNull($metric->value());
    }


    /** @test */
    public function it_returns_true_if_models_extends_another_model_in_the_project()
    {
        $project = $this->createProjectFromClasses([
            Group::class
        ]);

        $metric = new ModelsExtendOtherModel($project);

        $this->assertTrue($metric->value());
    }

    /** @test */
    public function it_returns_false_if_models_does_not_extend_another_model_in_the_project()
    {
        $project = $this->createProjectFromClasses([
            User::class
        ]);

        $metric = new ModelsExtendOtherModel($project);

        $this->assertFalse($metric->value());
    }
}
