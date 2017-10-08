<?php

namespace Wnx\LaravelStats\Tests\Commands;

use Illuminate\Support\Facades\Artisan;
use Wnx\LaravelStats\Commands\StatsListCommand;
use Wnx\LaravelStats\Tests\TestCase;

class StatisticsListCommandTest extends TestCase
{
    /** @test */
    public function it_works()
    {
        $this->artisan('stats');
        $resultAsText = Artisan::output();

        $this->assertContains('Controllers', $resultAsText);
        $this->assertContains('Total', $resultAsText);
    }
}
