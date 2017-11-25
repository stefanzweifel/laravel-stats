<?php

namespace Wnx\LaravelStats\Tests\RejectionStrategies;

use Wnx\LaravelStats\Tests\TestCase;
use Wnx\LaravelStats\ReflectionClass;
use Wnx\LaravelStats\Classifiers\ModelClassifier;
use Wnx\LaravelStats\RejectionStrategies\RejectInternalClasses;

class RejectInternalClassesTest extends TestCase
{
    /** @test */
    public function it_returns_true_if_the_given_class_is_a_php_internal()
    {
        $strategy = resolve(RejectInternalClasses::class);
        $class = new ReflectionClass(new \stdClass);

        $this->assertTrue($strategy->shouldClassBeRejected($class));
    }

    /** @test */
    public function it_returns_false_if_the_class_belongs_to_the_app()
    {
        $strategy = resolve(RejectInternalClasses::class);
        $class = new ReflectionClass(ModelClassifier::class);

        $this->assertFalse($strategy->shouldClassBeRejected($class));
    }
}
