<?php

namespace Wnx\LaravelStats\Tests\Stubs\Tests;

use PHPUnit\Framework\Attributes\Test;

abstract class DemoDuskTest extends \Laravel\Dusk\TestCase
{
    #[Test]
    public function this_is_dusk_test(): void
    {
        $this->assertTrue(true);
    }
}
