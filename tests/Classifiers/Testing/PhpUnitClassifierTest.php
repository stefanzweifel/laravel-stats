<?php declare(strict_types=1);

namespace Wnx\LaravelStats\Tests\Classifiers;

use PHPUnit\Framework\Attributes\Test;
use Wnx\LaravelStats\Tests\TestCase;
use Wnx\LaravelStats\ReflectionClass;
use Wnx\LaravelStats\Tests\Stubs\Tests\DemoUnitTest;
use Wnx\LaravelStats\Classifiers\Testing\PhpUnitClassifier;

class PhpUnitClassifierTest extends TestCase
{
    #[Test]
    public function it_returns_true_if_given_test_is_a_php_unit_test(): void
    {
        $this->assertTrue(
            (new PhpUnitClassifier())->satisfies(
                new ReflectionClass(DemoUnitTest::class)
            )
        );
    }
}
