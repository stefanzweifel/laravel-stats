<?php

namespace Wnx\LaravelStats\Tests\Classifiers;

use Wnx\LaravelStats\Classifiers\SeederClassifier;
use Wnx\LaravelStats\ReflectionClass;
use Wnx\LaravelStats\Tests\Stubs\Seeders\DemoSeeder;
use Wnx\LaravelStats\Tests\TestCase;

class SeederClassifierTest extends TestCase
{
    /** @test */
    public function it_returns_true_if_given_class_is_a_database_seeder()
    {
        $this->assertTrue(
            (new SeederClassifier())->satisfies(
                new ReflectionClass(DemoSeeder::class)
            )
        );
    }
}
