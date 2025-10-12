<?php declare(strict_types=1);

namespace Wnx\LaravelStats\Tests\Outputs;

use PHPUnit\Framework\Attributes\Test;
use Wnx\LaravelStats\Project;
use Wnx\LaravelStats\Tests\TestCase;
use Wnx\LaravelStats\ReflectionClass;
use Wnx\LaravelStats\Outputs\JsonOutput;
use Wnx\LaravelStats\Tests\Stubs\Rules\DemoRule;
use Wnx\LaravelStats\Tests\Stubs\Tests\DemoUnitTest;
use Wnx\LaravelStats\Tests\Stubs\Controllers\ProjectsController;
use Wnx\LaravelStats\Tests\Stubs\Models\Project as ProjectModel;

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

    #[Test]
    public function it_creates_project_statistics_as_an_array(): void
    {
        $json = (new JsonOutput)->render($this->getTestProject());

        $expected = [
            'components' => [
                [
                    'name' => 'Models',
                    'number_of_classes' => 1,
                    'number_of_methods' => 0,
                    'methods_per_class' => 0.0,
                    'loc' => 10,
                    'lloc' => 0,
                    'lloc_per_method' => 0,
                ],
                [
                    'name' => 'Other',
                    'number_of_classes' => 1,
                    'number_of_methods' => 3,
                    'methods_per_class' => 3.0,
                    'loc' => 21,
                    'lloc' => 3,
                    'lloc_per_method' => 1,
                ],
                [
                    'name' => 'PHPUnit Tests',
                    'number_of_classes' => 1,
                    'number_of_methods' => 1,
                    'methods_per_class' => 1.0,
                    'loc' => 16,
                    'lloc' => 1.0,
                    'lloc_per_method' => 1.0,
                ],
                [
                    'name' => 'Rules',
                    'number_of_classes' => 1,
                    'number_of_methods' => 3,
                    'methods_per_class' => 3.0,
                    'loc' => 39,
                    'lloc' => 1,
                    'lloc_per_method' => 0.33,
                ],
            ],
            'total' => [
                'number_of_classes' => 4,
                'number_of_methods' => 7,
                'methods_per_class' => 1.75,
                'loc' => 86,
                'lloc' => 5,
                'lloc_per_method' => 0.71,
            ],
            'meta' => [
                'code_lloc' => 4.0,
                'test_lloc' => 1.0,
                'code_to_test_ratio' => 0.3,
                'number_of_route' => $this->getLaravelVersion() < 12 ? 0 : 1,
            ],
        ];

        $this->assertEquals($expected, $json);
    }

    #[Test]
    public function it_includes_classes_in_project_statistics_array_if_verbose_output_is_requested(): void
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
            'lloc' => 0,
            'lloc_per_method' => 0.0,
        ];

        $this->assertEquals($expected, $classes[0]);
    }

    #[Test]
    public function it_only_contains_components_in_statistics_array_which_have_been_requested(): void
    {
        $json = (new JsonOutput)->render(
            $this->getTestProject(),
            $isVerbose = true,
            ['Rules', 'Other']
        );

        $components = collect($json['components']);

        $this->assertCount(2, $components);
        $this->assertCount(1, $components->where('name', 'Rules'));
        $this->assertCount(0, $components->where('name', 'Models'));
        $this->assertCount(1, $components->where('name', 'Other'));
        $this->assertCount(0, $components->where('name', 'PHPUnit Tests'));
    }
}
