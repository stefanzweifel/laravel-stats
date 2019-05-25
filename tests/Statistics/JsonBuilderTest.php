<?php declare(strict_types=1);

namespace Wnx\LaravelStats\Tests\Statistics;

use Wnx\LaravelStats\ReflectionClass;
use Wnx\LaravelStats\Statistics\JsonBuilder;
use Wnx\LaravelStats\Statistics\ProjectStatistics;
use Wnx\LaravelStats\Tests\Stubs\Controllers\ProjectsController;
use Wnx\LaravelStats\Tests\Stubs\Models\Project;
use Wnx\LaravelStats\Tests\Stubs\Tests\DemoDuskTest;
use Wnx\LaravelStats\Tests\Stubs\Tests\DemoUnitTest;
use Wnx\LaravelStats\Tests\TestCase;

class JsonBuilderTest extends TestCase
{
    public function components()
    {
        return collect([
            'Controllers' => collect([
                new ReflectionClass(ProjectsController::class),
            ]),
            'Models' => collect([
                new ReflectionClass(Project::class),
            ]),
            'PHPUnit Tests' => collect([
                new ReflectionClass(DemoUnitTest::class),
            ]),
            'Dusk Tests' => collect([
                new ReflectionClass(DemoDuskTest::class),
            ]),
        ]);
    }

    /** @test */
    public function it_returns_json()
    {
        $stats = new ProjectStatistics($this->components());
        $json = (new JsonBuilder($stats))->get();

        $this->assertJson($json);
    }

    /** @test */
    public function it_contains_a_meta_block()
    {
        $stats = new ProjectStatistics($this->components());
        $json = (new JsonBuilder($stats))->get();

        $this->assertArrayHasKey('meta', json_decode($json, true));
    }

    /** @test */
    public function it_contains_a_total_block()
    {
        $stats = new ProjectStatistics($this->components());
        $json = (new JsonBuilder($stats))->get();

        $this->assertArrayHasKey('total', json_decode($json, true));
    }

    /** @test */
    public function it_contains_a_components_block()
    {
        $stats = new ProjectStatistics($this->components());
        $json = (new JsonBuilder($stats))->get();

        $this->assertArrayHasKey('components', json_decode($json, true));
    }

    /** @test */
    public function it_contains_meta_total_and_components_block_when_no_components_are_given()
    {
        $stats = new ProjectStatistics(collect([]));
        $json = (new JsonBuilder($stats))->get();

        $this->assertArrayHasKey('meta', json_decode($json, true));
        $this->assertArrayHasKey('total', json_decode($json, true));
        $this->assertArrayHasKey('components', json_decode($json, true));
    }
}
