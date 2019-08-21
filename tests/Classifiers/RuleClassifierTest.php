<?php

namespace Wnx\LaravelStats\Tests\Classifiers;

use Wnx\LaravelStats\Tests\TestCase;
use Wnx\LaravelStats\ReflectionClass;
use Wnx\LaravelStats\Classifiers\RuleClassifier;
use Wnx\LaravelStats\Tests\Stubs\Rules\DemoRule;

class RuleClassifierTest extends TestCase
{
    /** @test */
    public function it_returns_true_if_given_class_is_a_validation_rule()
    {
        $this->assertTrue(
            (new RuleClassifier())->satisfies(
                new ReflectionClass(DemoRule::class)
            )
        );
    }
}
