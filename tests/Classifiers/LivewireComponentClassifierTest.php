<?php declare(strict_types=1);

namespace Wnx\LaravelStats\Tests\Classifiers;

use Illuminate\Support\Facades\Route;
use Wnx\LaravelStats\Classifiers\LivewireComponentClassifier;
use Wnx\LaravelStats\ReflectionClass;
use Wnx\LaravelStats\Tests\Stubs\LivewireComponents\StubLivewireComponent;
use Wnx\LaravelStats\Tests\TestCase;

class LivewireComponentClassifierTest extends TestCase
{
    /** @test */
    public function it_returns_true_if_given_class_is_a_livewire_component(): void
    {
        $this->assertTrue(
            (new LivewireComponentClassifier())->satisfies(
                new ReflectionClass(StubLivewireComponent::class)
            )
        );
    }

    /** @test */
    public function it_returns_true_if_given_class_is_a_livewire_component_which_is_associated_with_a_registered_route(): void
    {
        Route::get('users', StubLivewireComponent::class);

        $this->assertTrue(
            (new LivewireComponentClassifier())->satisfies(
                new ReflectionClass(StubLivewireComponent::class)
            )
        );
    }
}
