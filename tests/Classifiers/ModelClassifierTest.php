<?php

namespace Wnx\LaravelStats\Tests\Classifiers;

use Wnx\LaravelStats\Tests\TestCase;
use Wnx\LaravelStats\ReflectionClass;
use Wnx\LaravelStats\Tests\Stubs\Models\Project;
use Wnx\LaravelStats\Classifiers\ModelClassifier;

class ModelClassifierTest extends TestCase
{
    /** @test */
    public function it_returns_true_if_given_class_is_an_eloquent_model()
    {
        $this->assertTrue(
            (new ModelClassifier())->satisfies(
                new ReflectionClass(Project::class)
            )
        );
    }
}
