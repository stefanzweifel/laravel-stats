<?php declare(strict_types=1);

namespace Wnx\LaravelStats\Tests;

use Wnx\LaravelStats\Classifier;
use Wnx\LaravelStats\ReflectionClass;
use Wnx\LaravelStats\Console\StatsListCommand;
use Wnx\LaravelStats\Classifiers\NullClassifier;
use Wnx\LaravelStats\Tests\Stubs\MyCustomComponentClass;
use Wnx\LaravelStats\Tests\Stubs\MyCustomComponentClassifier;
use Wnx\LaravelStats\Tests\Stubs\ThrowExceptionCustomComponentClassifier;

class ClassifierTest extends TestCase
{
    public function getClassifier($args)
    {
        return (new Classifier())->getClassifierForClassInstance(new ReflectionClass($args));
    }

    /** @test */
    public function it_returns_instance_of_null_classifier_if_given_class_could_not_be_associated_with_a_component(): void
    {
        $this->assertInstanceOf(
            NullClassifier::class,
            $this->getClassifier(
                new class() {
                }
            )
        );
    }

    /** @test */
    public function it_returns_instance_of_custom_classifier_if_the_custom_classifier_has_been_registered_correctly(): void
    {
        config()->set('stats.custom_component_classifier', [
            MyCustomComponentClassifier::class,
        ]);

        $this->assertInstanceOf(
            MyCustomComponentClassifier::class,
            $this->getClassifier(
                MyCustomComponentClass::class
            )
        );
    }

    /** @test */
    public function it_returns_an_instance_of_null_classifier_if_during_the_satisfy_check_an_exception_is_thrown(): void
    {
        config()->set('stats.custom_component_classifier', [
            ThrowExceptionCustomComponentClassifier::class,
        ]);

        $this->assertInstanceOf(
            NullClassifier::class,
            $this->getClassifier(
                MyCustomComponentClass::class
            )
        );
    }

    /** @test */
    public function it_throws_an_exception_if_a_custom_component_classifier_does_not_follow_the_contract(): void
    {
        $this->expectException(\Exception::class);

        config()->set('stats.custom_component_classifier', [
            StatsListCommand::class,
        ]);

        $this->getClassifier(new ReflectionClass(MyCustomComponentClass::class));
    }
}
