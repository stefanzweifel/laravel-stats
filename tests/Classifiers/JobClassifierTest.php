<?php declare(strict_types=1);

namespace Wnx\LaravelStats\Tests\Classifiers;

use Wnx\LaravelStats\Tests\TestCase;
use Wnx\LaravelStats\ReflectionClass;
use Wnx\LaravelStats\Tests\Stubs\Jobs\DemoJob;
use Wnx\LaravelStats\Classifiers\JobClassifier;

class JobClassifierTest extends TestCase
{
    /** @test */
    public function it_returns_true_if_given_class_is_a_job(): void
    {
        $this->assertTrue(
            (new JobClassifier())->satisfies(
                new ReflectionClass(DemoJob::class)
            )
        );
    }
}
