<?php

namespace Wnx\LaravelStats\Tests\Stubs\Tests;

use Laravel\BrowserKitTesting\TestCase;

class DemoBrowserKit extends TestCase
{
    public function createApplication(): void
    {
        //
    }

    /** @test */
    public function it_runs_browser_kit_tests(): void
    {
        $this->assertTrue(true);
    }
}
