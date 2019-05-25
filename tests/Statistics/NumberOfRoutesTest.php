<?php declare(strict_types=1);

namespace Wnx\LaravelStats\Tests\Statistics;

use Illuminate\Support\Facades\Route;
use Wnx\LaravelStats\Statistics\NumberOfRoutes;
use Wnx\LaravelStats\Tests\TestCase;

class NumberOfRoutesTest extends TestCase
{
    /** @test */
    public function it_returns_0_if_no_routes_are_registered()
    {
        $result = app(NumberOfRoutes::class)->get();

        $this->assertEquals(0, $result);
    }

    /** @test */
    public function it_returns_the_number_of_registered_routes()
    {
        Route::get('users', 'Wnx\LaravelStats\Tests\Stubs\Controllers\UsersController@index');
        Route::get('users/create', 'Wnx\LaravelStats\Tests\Stubs\Controllers\UsersController@create');
        Route::post('users', 'Wnx\LaravelStats\Tests\Stubs\Controllers\UsersController@store');
        Route::get('users/{user}', 'Wnx\LaravelStats\Tests\Stubs\Controllers\UsersController@show');
        Route::get('users/{user}/edit', 'Wnx\LaravelStats\Tests\Stubs\Controllers\UsersController@edit');
        Route::patch('users/{user}', 'Wnx\LaravelStats\Tests\Stubs\Controllers\UsersController@update');
        Route::delete('users/{user}', 'Wnx\LaravelStats\Tests\Stubs\Controllers\UsersController@destroy');

        $result = app(NumberOfRoutes::class)->get();

        $this->assertEquals(7, $result);
    }

    /** @test */
    public function it_only_counts_unique_routes()
    {
        Route::get('users', 'Wnx\LaravelStats\Tests\Stubs\Controllers\UsersController@index');
        Route::get('users', 'Wnx\LaravelStats\Tests\Stubs\Controllers\UsersController@create');

        $result = app(NumberOfRoutes::class)->get();

        $this->assertEquals(1, $result);
    }
}
