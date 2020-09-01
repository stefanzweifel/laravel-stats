<?php declare(strict_types=1);

namespace Wnx\LaravelStats\Tests\ShareableMetrics\Metrics;

use Wnx\LaravelStats\ShareableMetrics\Metrics\InstalledPackages;
use Wnx\LaravelStats\Tests\TestCase;

class InstalledPackagesTest extends TestCase
{
    /** @test */
    public function it_returns_correct_metric_name()
    {
        $project = $this->createProjectFromClasses([]);

        $metric = new InstalledPackages($project);

        $this->assertEquals('packages', $metric->name());
    }

    /** @test */
    public function it_returns_array_of_installed_packages_for_the_project()
    {
        $project = $this->createProjectFromClasses([]);

        $metric = new InstalledPackages($project);

        $value = $metric->value();

        $this->assertIsArray($value);
        $this->assertArrayHasKey('require', $value);
        $this->assertArrayHasKey('require-dev', $value);

        $this->assertEquals([
            'require' => [
                'laravel/framework' => '~5.0'
            ],
            'require-dev' => [
                'phpunit/phpunit' => '~4.0'
            ]
        ], $value);
    }
}
