<?php declare(strict_types=1);

namespace Wnx\LaravelStats\Tests\RejectionStrategies;

use Wnx\LaravelStats\Classifiers\ModelClassifier;
use Wnx\LaravelStats\ReflectionClass;
use Wnx\LaravelStats\RejectionStrategies\RejectInternalClasses;
use Wnx\LaravelStats\Tests\TestCase;

class RejectInternalClassesTest extends TestCase
{
    /** @test */
    public function it_returns_true_if_the_given_class_is_a_php_internal()
    {
        $strategy = app(RejectInternalClasses::class);
        $class = new ReflectionClass(new \stdClass);

        $this->assertTrue($strategy->shouldClassBeRejected($class));
    }

    /** @test */
    public function it_returns_false_if_the_class_belongs_to_the_app()
    {
        $strategy = app(RejectInternalClasses::class);
        $class = new ReflectionClass(ModelClassifier::class);

        $this->assertFalse($strategy->shouldClassBeRejected($class));
    }
}
