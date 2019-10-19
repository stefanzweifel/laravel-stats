<?php declare(strict_types=1);

namespace Wnx\LaravelStats\Tests\Classifiers\Nova;

use Wnx\LaravelStats\Tests\TestCase;
use Wnx\LaravelStats\ReflectionClass;
use Wnx\LaravelStats\Tests\Stubs\Nova\DemoAction;
use Wnx\LaravelStats\Classifiers\Nova\ActionClassifier;

class ActionClassifierTest extends TestCase
{
    /** @test */
    public function it_returns_true_if_given_class_is_a_nova_action()
    {
        $this->assertTrue(
            (new ActionClassifier())->satisfies(
                new ReflectionClass(DemoAction::class)
            )
        );
    }
}
