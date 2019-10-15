<?php declare(strict_types=1);

namespace Wnx\LaravelStats\Tests\Classifiers\Nova;

use Wnx\LaravelStats\Tests\TestCase;
use Wnx\LaravelStats\ReflectionClass;
use Wnx\LaravelStats\Tests\Stubs\Nova\DemoDashboard;
use Wnx\LaravelStats\Classifiers\Nova\DashboardClassifier;

class DashboardClassifierTest extends TestCase
{
    /** @test */
    public function it_returns_true_if_given_class_is_a_nova_dashboard()
    {
        $this->assertTrue(
            (new DashboardClassifier())->satisfies(
                new ReflectionClass(DemoDashboard::class)
            )
        );
    }
}
