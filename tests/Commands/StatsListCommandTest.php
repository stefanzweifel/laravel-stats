<?php

namespace Wnx\LaravelStats\Tests\Commands;

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;
use Wnx\LaravelStats\Tests\TestCase;

class StatsListCommandTest extends TestCase
{
    /** @test */
    public function it_works()
    {
        Route::get('projects', 'Wnx\LaravelStats\Tests\Stubs\Controllers\ProjectsController@index');
        Route::get('users', 'Wnx\LaravelStats\Tests\Stubs\Controllers\UsersController@index');

        $this->artisan('stats');
        $resultAsText = Artisan::output();

        $this->assertContains('Middlewares', $resultAsText);
        $this->assertContains('Controllers', $resultAsText);
        $this->assertContains('Total', $resultAsText);
    }
}
