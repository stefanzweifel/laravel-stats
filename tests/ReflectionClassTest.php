<?php declare(strict_types=1);

namespace Wnx\LaravelStats\Tests;

use PHPUnit\Framework\Attributes\Test;
use Wnx\LaravelStats\ReflectionClass;
use Wnx\LaravelStats\Tests\Stubs\Controllers\Controller;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Wnx\LaravelStats\Tests\Stubs\Controllers\ProjectsController;

class ReflectionClassTest extends TestCase
{
    #[Test]
    public function it_returns_a_list_of_methods_for_the_given_class_and_ignores_parent_and_trait_methods(): void
    {
        $class = new ReflectionClass(ProjectsController::class);

        $this->assertCount(
            3,
            $class->getDefinedMethods()
        );
    }

    #[Test]
    public function it_determines_wether_the_given_class_uses_a_given_trait(): void
    {
        $class = new ReflectionClass(Controller::class);

        $this->assertTrue(
            $class->usesTrait(AuthorizesRequests::class)
        );
    }
}
