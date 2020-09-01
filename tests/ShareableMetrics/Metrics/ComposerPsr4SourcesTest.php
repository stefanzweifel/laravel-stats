<?php declare(strict_types=1);

namespace Wnx\LaravelStats\Tests\ShareableMetrics\Metrics;

use Wnx\LaravelStats\ShareableMetrics\Metrics\ComposerPsr4Sources;
use Wnx\LaravelStats\Tests\TestCase;

class ComposerPsr4SourcesTest extends TestCase
{
    /** @test */
    public function it_returns_correct_metric_name()
    {
        $project = $this->createProjectFromClasses([]);

        $metric = new ComposerPsr4Sources($project);

        $this->assertEquals('composer_psr_4_namespaces', $metric->name());
    }

    /** @test */
    public function it_returns_composer_psr_4_sources()
    {
        $project = $this->createProjectFromClasses([]);

        $metric = new ComposerPsr4Sources($project);

        $value = $metric->value();

        $this->assertIsArray($value);

        // dd($value);

        $this->assertEquals([
            "App\\" => 'app/'
        ], $value);
    }
}
