<?php

namespace Wnx\LaravelStats\Tests\Filters;

use Wnx\LaravelStats\Classifiers\ModelClassifier;
use Wnx\LaravelStats\Filters\RejectInternalClasses;
use Wnx\LaravelStats\ReflectionClass;
use Wnx\LaravelStats\Tests\TestCase;

class RejectInternalClassesTest extends TestCase
{
    /** @test */
    public function it_returns_true_if_the_given_class_is_a_php_internal()
    {
        $filter = resolve(RejectInternalClasses::class);
        $class = new ReflectionClass(new \stdClass);

        $this->assertTrue($filter->shouldBeRejected($class));
    }

    /** @test */
    public function it_returns_false_if_the_class_belongs_to_the_app()
    {
        $filter = resolve(RejectInternalClasses::class);
        $class = new ReflectionClass(ModelClassifier::class);

        $this->assertFalse($filter->shouldBeRejected($class));
    }
}
