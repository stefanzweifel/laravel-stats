<?php

namespace Wnx\LaravelStats\Tests;

use Illuminate\Support\Collection;
use Wnx\LaravelStats\ComponentSort;
use Illuminate\Support\Facades\Route;
use Wnx\LaravelStats\Tests\Stubs\Models\Project;
use Wnx\LaravelStats\Tests\Stubs\Events\DemoEvent;
use Wnx\LaravelStats\Tests\Stubs\Controllers\ProjectsController;

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
}
