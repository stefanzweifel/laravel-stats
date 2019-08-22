<?php

namespace Wnx\LaravelStats\Tests\Outputs;

use Wnx\LaravelStats\Outputs\JsonOutput;
use Wnx\LaravelStats\Project;
use Wnx\LaravelStats\ReflectionClass;
use Wnx\LaravelStats\Tests\Stubs\Controllers\ProjectsController;
use Wnx\LaravelStats\Tests\Stubs\Models\Project as ProjectModel;
use Wnx\LaravelStats\Tests\Stubs\Rules\DemoRule;
use Wnx\LaravelStats\Tests\Stubs\Tests\DemoUnitTest;
use Wnx\LaravelStats\Tests\TestCase;

class JsonOutputTest extends TestCase
{

    public function getTestProject()
    {
        $classes = collect([
            new ReflectionClass(ProjectModel::class),
            new ReflectionClass(ProjectsController::class),
            new ReflectionClass(DemoRule::class),
            new ReflectionClass(DemoUnitTest::class),
        ]);

        return new Project($classes);
    }

    /** @test */
    public function it_creates_project_statistics_as_an_array()
    {
        $json = (new JsonOutput)->render($this->getTestProject());

        $expected = [
            'components' => [
                [
                    'name' => 'Models',
                    'number_of_classes' => 1,
                    'number_of_methods' => 0,
                    'methods_per_class' => 0,
                    'loc' => 10,
                    'lloc' => 2,
                    'lloc_per_method' => 0
                ],
                [
                    'name' => 'Other',
                    'number_of_classes' => 1,
                    'number_of_methods' => 3,
                    'methods_per_class' => 3,
                    'loc' => 21,
                    'lloc' => 4,
                    'lloc_per_method' => 1.33
                ],
                [
                    'name' => 'PHPUnit Tests',
                    'number_of_classes' => 1,
                    'number_of_methods' => 1,
                    'methods_per_class' => 1,
                    'loc' => 18,
                    'lloc' => 3,
                    'lloc_per_method' => 3
                ],
                [
                    'name' => 'Rules',
                    'number_of_classes' => 1,
                    'number_of_methods' => 3,
                    'methods_per_class' => 3,
                    'loc' => 41,
                    'lloc' => 3,
                    'lloc_per_method' => 1
                ]
            ],
            'total' => [
                'number_of_classes' => 4,
                'number_of_methods' => 7,
                'methods_per_class' => 1.75,
                'loc' => 90,
                'lloc' => 12,
                'lloc_per_method' => 1.71,
            ],
            'meta' => [
                'code_lloc' => 9,
                'test_lloc' => 3,
                'code_to_test_ratio' => 0.3,
                'number_of_routes' => 0
            ]
        ];

        $this->assertEquals($expected, $json);
    }

    /** @test */
    public function it_includes_classes_in_project_statistics_array_if_verbose_output_is_requested()
    {
        $json = (new JsonOutput)->render($this->getTestProject(), $isVerbose = true);

        $components = collect($json['components']);
        $modelsComponent = $components->where('name', 'Models')->first();

        $this->assertArrayHasKey('classes', $modelsComponent);

        $classes = $modelsComponent['classes'];

        $expected = [
            'name' => ProjectModel::class,
            'methods' => 0,
            'methods_per_class' => 0,
            'loc' => 10,
            'lloc' => 2.0,
            'lloc_per_method' => 0.0
        ];

        $this->assertEquals($expected, $classes[0]);
    }

    /** @test */
    public function it_only_contains_components_in_statistics_array_which_have_been_requested()
    {
        $json = (new JsonOutput)->render(
            $this->getTestProject(),
            $isVerbose = true,
            'Rules'
        );

        $components = collect($json['components']);

        $this->assertCount(1, $components);
        $this->assertCount(1, $components->where('name', 'Rules'));
        $this->assertCount(0, $components->where('name', 'Models'));
        $this->assertCount(0, $components->where('name', 'Others'));
        $this->assertCount(0, $components->where('name', 'PHPUnit Tests'));
    }

}
