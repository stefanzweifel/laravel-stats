<?php declare(strict_types=1);

namespace Wnx\LaravelStats\Tests\Classifiers;

use Wnx\LaravelStats\Tests\TestCase;
use Illuminate\Support\Facades\Route;
use Wnx\LaravelStats\ReflectionClass;
use Wnx\LaravelStats\Classifiers\ControllerClassifier;
use Wnx\LaravelStats\Tests\Stubs\Controllers\UsersController;
use Wnx\LaravelStats\Tests\Stubs\Controllers\ProjectsController;

class ControllerClassifierTest extends TestCase
{
    /** @test */
    public function it_returns_true_if_given_class_is_a_controller_which_is_associated_with_a_registered_route(): void
    {
        Route::get('users', 'Wnx\LaravelStats\Tests\Stubs\Controllers\UsersController@index');

        $this->assertTrue(
            (new ControllerClassifier())->satisfies(
                new ReflectionClass(UsersController::class)
            )
        );
    }

    /** @test */
    public function it_returns_false_if_given_class_is_not_associated_with_a_registered_route(): void
    {
        $this->assertFalse(
            (new ControllerClassifier())->satisfies(
                new ReflectionClass(UsersController::class)
            )
        );
    }

    /** @test */
    public function it_does_not_throw_an_exception_if_controller_for_a_route_could_not_be_found(): void
    {
        Route::get('users', 'Wnx\LaravelStats\Tests\Stubs\Controllers\NotFoundController@index');

        $this->assertFalse(
            (new ControllerClassifier())->satisfies(
                new ReflectionClass(UsersController::class)
            )
        );
    }

    /** @test */
    public function it_returns_true_when_controller_does_not_extend_laravels_base_controller(): void
    {
        Route::get('projects', 'Wnx\LaravelStats\Tests\Stubs\Controllers\ProjectsController@index');

        $this->assertTrue(
            (new ControllerClassifier())->satisfies(
                new ReflectionClass(ProjectsController::class)
            )
        );
    }
}
