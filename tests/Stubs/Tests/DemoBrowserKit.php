<?php

namespace Wnx\LaravelStats\Tests\Stubs\Tests;

use Laravel\BrowserKitTesting\TestCase;
use PHPUnit\Framework\Attributes\Test;

class DemoBrowserKit extends TestCase
{
    public function createApplication(): void
    {
        //
    }

    #[Test]
    public function it_runs_browser_kit_tests(): void
    {
        $this->assertTrue(true);
    }
}
