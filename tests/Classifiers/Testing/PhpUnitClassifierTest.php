<?php declare(strict_types=1);

namespace Wnx\LaravelStats\Tests\Classifiers;

use Wnx\LaravelStats\Tests\TestCase;
use Wnx\LaravelStats\ReflectionClass;
use Wnx\LaravelStats\Tests\Stubs\Tests\DemoUnitTest;
use Wnx\LaravelStats\Classifiers\Testing\PhpUnitClassifier;

class PhpUnitClassifierTest extends TestCase
{
    /** @test */
    public function it_returns_true_if_given_test_is_a_php_unit_test()
    {
        $this->assertTrue(
            (new PhpUnitClassifier())->satisfies(
                new ReflectionClass(DemoUnitTest::class)
            )
        );
    }
}
