<?php declare(strict_types=1);

namespace Wnx\LaravelStats\Tests\Classifiers;

use PHPUnit\Framework\Attributes\Test;
use Wnx\LaravelStats\Tests\TestCase;
use Wnx\LaravelStats\ReflectionClass;
use Wnx\LaravelStats\Classifiers\DatabaseFactoryClassifier;
use Wnx\LaravelStats\Tests\Stubs\DatabaseFactories\StubUserDatabaseFactory;

class DatabaseFactoryClassifierTest extends TestCase
{
    #[Test]
    public function it_returns_true_if_database_factory_is_passed_to_satisfy_method(): void
    {
        $this->assertTrue(
            (new DatabaseFactoryClassifier())->satisfies(
                new ReflectionClass(StubUserDatabaseFactory::class)
            )
        );
    }

    #[Test]
    public function it_does_not_count_database_factory_againt_app_code(): void
    {
        $this->assertFalse((new DatabaseFactoryClassifier())->countsTowardsApplicationCode());
    }

    #[Test]
    public function it_does_not_count_database_factor_against_test_code(): void
    {
        $this->assertFalse((new DatabaseFactoryClassifier())->countsTowardsTests());
    }
}
