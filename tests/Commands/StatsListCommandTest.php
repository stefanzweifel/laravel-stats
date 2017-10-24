<?php

namespace Wnx\LaravelStats\Tests\Commands;

use Wnx\LaravelStats\Tests\TestCase;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;

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
        $this->assertContains('Other', $resultAsText);
        $this->assertContains('Total', $resultAsText);
    }

    /** @test */
    public function it_displays_all_headers()
    {
        $this->artisan('stats');
        $result = Artisan::output();

        $this->assertContains('Name', $result);
        $this->assertContains('Classes', $result);
        $this->assertContains('Methods', $result);
        $this->assertContains('Methods/Class', $result);
        $this->assertContains('Lines', $result);
        $this->assertContains('LoC', $result);
        $this->assertContains('LoC/Method', $result);
    }
}
