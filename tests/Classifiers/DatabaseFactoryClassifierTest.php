<?php declare(strict_types=1);

namespace Wnx\LaravelStats\Tests\Classifiers;

use Wnx\LaravelStats\Tests\TestCase;
use Wnx\LaravelStats\ReflectionClass;
use Wnx\LaravelStats\Classifiers\DatabaseFactoryClassifier;
use Wnx\LaravelStats\Tests\Stubs\DatabaseFactories\StubUserDatabaseFactory;

class DatabaseFactoryClassifierTest extends TestCase
{
    /** @test */
    public function it_returns_true_if_database_factory_is_passed_to_satisfy_method()
    {
        if ($this->getLaravelVersion() < 8) {
            $this->markTestSkipped("Can't run test on older Laravel Versions");
        }

        $this->assertTrue(
            (new DatabaseFactoryClassifier())->satisfies(
                new ReflectionClass(StubUserDatabaseFactory::class)
            )
        );
    }

    /** @test */
    public function it_does_not_count_database_factory_againt_app_code()
    {
        if ($this->getLaravelVersion() < 8) {
            $this->markTestSkipped("Can't run test on older Laravel Versions");
        }

        $this->assertFalse((new DatabaseFactoryClassifier())->countsTowardsApplicationCode());
    }

    /** @test */
    public function it_does_not_count_database_factor_against_test_code()
    {
        if ($this->getLaravelVersion() < 8) {
            $this->markTestSkipped("Can't run test on older Laravel Versions");
        }

        $this->assertFalse((new DatabaseFactoryClassifier())->countsTowardsTests());
    }
}
