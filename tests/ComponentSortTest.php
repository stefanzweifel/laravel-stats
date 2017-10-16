<?php

namespace Wnx\LaravelStats\Tests;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Route;
use Wnx\LaravelStats\Component;
use Wnx\LaravelStats\ComponentSort;
use Wnx\LaravelStats\Tests\Stubs\Controllers\ProjectsController;
use Wnx\LaravelStats\Tests\Stubs\Events\DemoEvent;
use Wnx\LaravelStats\Tests\Stubs\Models\Project;

class ComponentSortTest extends TestCase
{
    /** @test */
    public function it_sorts_a_collection_of_classes_into_components()
    {
        Route::get('projects', 'Wnx\LaravelStats\Tests\Stubs\Controllers\ProjectsController@index');

        $sort = resolve(ComponentSort::class);

        $classes = collect([
            DemoEvent::class,
            Project::class,
            ProjectsController::class,
        ]);

        $components = $sort->sortClassesIntoComponents($classes);

        $this->assertInstanceOf(Collection::class, $components);
        $this->assertCount(3, $components);

        $this->assertEquals('Events', $components->first()->getName());
        $this->assertCount(1, $components->first()->getClasses());
    }

    /** @test */
    public function it_discards_classes_which_could_not_be_sorted_into_components()
    {
        $sort = resolve(ComponentSort::class);

        $classes = collect([
            new class() {
            },
            Component::class,
        ]);

        $components = $sort->sortClassesIntoComponents($classes);

        $this->assertInstanceOf(Collection::class, $components);

        $this->assertCount(0, $components);
    }
}
