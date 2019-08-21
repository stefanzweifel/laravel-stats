<?php

namespace Wnx\LaravelStats\Tests;

use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Route;
use Wnx\LaravelStats\Classifier;
use Wnx\LaravelStats\Console\StatsListCommand;
use Wnx\LaravelStats\ReflectionClass;
use Wnx\LaravelStats\Tests\Stubs\EventListeners\DemoEventListener;
use Wnx\LaravelStats\Tests\Stubs\MyCustomComponentClass;
use Wnx\LaravelStats\Tests\Stubs\MyCustomComponentClassifier;
use Wnx\LaravelStats\Tests\Stubs\Tests\DemoBrowserKit;
use Wnx\LaravelStats\Tests\Stubs\Tests\DemoDuskTest;

class ClassifierTest extends TestCase
{
    public function setUp() : void
    {
        parent::setUp();

        $this->classifier = new Classifier();
    }

    public function getClassifier($args)
    {
        return (new Classifier())->getClassifierForClassInstance(new ReflectionClass($args));
    }

    /** @test */
    public function it_returns_null_classifier_instance_for_unidentified_class()
    {
        $this->assertInstanceOf(
            \Wnx\LaravelStats\Classifiers\NullClassifier::class,
            $this->getClassifier(
                new class() {}
            )
        );
    }

    /** @test */
    public function it_detects_phpunit_tests()
    {
        $this->assertSame(
            'PHPUnit Tests', $this->classifier->classify(new ReflectionClass(\Wnx\LaravelStats\Tests\Stubs\Tests\DemoUnitTest::class))
        );
    }

    /** @test */
    public function it_detects_dusk_tests()
    {
        $this->assertSame(
            'DuskTests', $this->classifier->classify(new ReflectionClass(DemoDuskTest::class))
        );
    }

    /** @test */
    public function it_detects_browserkit_tests()
    {
        $this->assertSame(
            'BrowserKit Tests', $this->classifier->classify(new ReflectionClass(DemoBrowserKit::class))
        );
    }

    /** @test */
    public function it_detects_event_listeners()
    {
        $this->assertSame(
            'Event Listeners', $this->classifier->classify(new ReflectionClass(DemoEventListener::class))
        );
    }

    /** @test */
    public function it_detects_custom_components()
    {
        config()->set('stats.custom_component_classifier', [
            MyCustomComponentClassifier::class,
        ]);

        $this->assertSame(
            'My Custom Component',
            $this->classifier->classify(new ReflectionClass(MyCustomComponentClass::class))
        );
    }

    /** @test */
    public function it_throws_an_exception_if_a_custom_component_classifier_does_not_follow_the_contract()
    {
        $this->expectException(\Exception::class);

        config()->set('stats.custom_component_classifier', [
            StatsListCommand::class,
        ]);

        $this->classifier->classify(new ReflectionClass(MyCustomComponentClass::class));
    }
}
