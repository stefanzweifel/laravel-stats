<?php

namespace Wnx\LaravelStats\Tests\Classifiers;

use Wnx\LaravelStats\Classifiers\JobClassifier;
use Wnx\LaravelStats\ReflectionClass;
use Wnx\LaravelStats\Tests\Stubs\Jobs\DemoJob;
use Wnx\LaravelStats\Tests\TestCase;

class JobClassifierTest extends TestCase
{
    /** @test */
    public function it_returns_true_if_given_class_is_a_job()
    {
        $this->assertTrue(
            (new JobClassifier())->satisfies(
                new ReflectionClass(DemoJob::class)
            )
        );
    }
}
