<?php declare(strict_types=1);

namespace Wnx\LaravelStats\Tests\Classifiers;

use Wnx\LaravelStats\Tests\TestCase;
use Wnx\LaravelStats\ReflectionClass;
use Wnx\LaravelStats\Tests\Stubs\Tests\DemoDuskTest;
use Wnx\LaravelStats\Classifiers\Testing\DuskClassifier;

class DuskClassifierTest extends TestCase
{
    /** @test */
    public function it_returns_true_if_given_test_is_a_dusk_test(): void
    {
        $this->assertTrue(
            (new DuskClassifier())->satisfies(
                new ReflectionClass(DemoDuskTest::class)
            )
        );
    }
}
