<?php

declare(strict_types=1);

namespace Wnx\LaravelStats\Tests\Stubs\Tests;

use Laravel\BrowserKitTesting\TestCase;

class DemoBrowserKit extends TestCase
{
    public function createApplication()
    {
        //
    }

    /** @test */
    public function it_runs_browser_kit_tests()
    {
        $this->assertTrue(true);
    }
}
