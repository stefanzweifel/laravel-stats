<?php

namespace Wnx\LaravelStats\Tests\Classifiers;

use Wnx\LaravelStats\Classifiers\Testing\BrowserKitTestClassifier;
use Wnx\LaravelStats\ReflectionClass;
use Wnx\LaravelStats\Tests\Stubs\Tests\DemoBrowserKit;
use Wnx\LaravelStats\Tests\TestCase;

class BrowserKitTestCaseClassifierTest extends TestCase
{
    /** @test */
    public function it_returns_true_if_given_test_is_a_browser_kit_test()
    {
        $this->assertTrue(
            (new BrowserKitTestClassifier())->satisfies(
                new ReflectionClass(DemoBrowserKit::class)
            )
        );
    }
}
