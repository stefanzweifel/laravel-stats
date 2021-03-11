<?php declare(strict_types=1);

namespace Wnx\LaravelStats\Tests\ShareableMetrics\Metrics;

use Wnx\LaravelStats\ShareableMetrics\Metrics\CodeTestRatio;
use Wnx\LaravelStats\Tests\Stubs\Models\User;
use Wnx\LaravelStats\Tests\Stubs\Tests\DemoBrowserKit;
use Wnx\LaravelStats\Tests\Stubs\Tests\DemoDuskTest;
use Wnx\LaravelStats\Tests\Stubs\Tests\DemoUnitTest;
use Wnx\LaravelStats\Tests\TestCase;

class CodeTestRatioTest extends TestCase
{
    /** @test */
    public function it_returns_correct_metric_name()
    {
        $project = $this->createProjectFromClasses([]);

        $metric = new CodeTestRatio($project);

        $this->assertEquals('code_test_ratio', $metric->name());
    }

    /** @test */
    public function it_returns_ratio_of_app_and_test_code()
    {
        $project = $this->createProjectFromClasses([
            User::class,
            DemoDuskTest::class,
            DemoUnitTest::class,
            DemoBrowserKit::class,
        ]);

        $metric = new CodeTestRatio($project);

        $this->assertEquals(0.6, $metric->value());
    }
}
