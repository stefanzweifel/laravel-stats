<?php declare(strict_types=1);

namespace Wnx\LaravelStats\Tests\Classifiers;

use PHPUnit\Framework\Attributes\Test;
use Wnx\LaravelStats\Tests\TestCase;
use Wnx\LaravelStats\ReflectionClass;
use Wnx\LaravelStats\Classifiers\SeederClassifier;
use Wnx\LaravelStats\Tests\Stubs\Seeders\DemoSeeder;

class SeederClassifierTest extends TestCase
{
    #[Test]
    public function it_returns_true_if_given_class_is_a_database_seeder(): void
    {
        $this->assertTrue(
            (new SeederClassifier())->satisfies(
                new ReflectionClass(DemoSeeder::class)
            )
        );
    }
}
