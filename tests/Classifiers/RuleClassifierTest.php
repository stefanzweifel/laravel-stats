<?php declare(strict_types=1);

namespace Wnx\LaravelStats\Tests\Classifiers;

use PHPUnit\Framework\Attributes\Test;
use Wnx\LaravelStats\Tests\TestCase;
use Wnx\LaravelStats\ReflectionClass;
use Wnx\LaravelStats\Classifiers\RuleClassifier;
use Wnx\LaravelStats\Tests\Stubs\Rules\DemoRule;

class RuleClassifierTest extends TestCase
{
    #[Test]
    public function it_returns_true_if_given_class_is_a_validation_rule(): void
    {
        $this->assertTrue(
            (new RuleClassifier())->satisfies(
                new ReflectionClass(DemoRule::class)
            )
        );
    }
}
