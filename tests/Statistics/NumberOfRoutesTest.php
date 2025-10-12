<?php declare(strict_types=1);

namespace Wnx\LaravelStats\Tests\Statistics;

use PHPUnit\Framework\Attributes\Test;
use Wnx\LaravelStats\Tests\TestCase;
use Illuminate\Support\Facades\Route;
use Wnx\LaravelStats\Statistics\NumberOfRoutes;

class NumberOfRoutesTest extends TestCase
{
    #[Test]
    public function it_returns_0_if_no_routes_are_registered(): void
    {
        $result = app(NumberOfRoutes::class)->get();

        $this->assertEquals(1, $result);
    }

    #[Test]
    public function it_returns_the_number_of_registered_routes(): void
    {
        Route::get('users', 'Wnx\LaravelStats\Tests\Stubs\Controllers\UsersController@index');
        Route::get('users/create', 'Wnx\LaravelStats\Tests\Stubs\Controllers\UsersController@create');
        Route::post('users', 'Wnx\LaravelStats\Tests\Stubs\Controllers\UsersController@store');
        Route::get('users/{user}', 'Wnx\LaravelStats\Tests\Stubs\Controllers\UsersController@show');
        Route::get('users/{user}/edit', 'Wnx\LaravelStats\Tests\Stubs\Controllers\UsersController@edit');
        Route::patch('users/{user}', 'Wnx\LaravelStats\Tests\Stubs\Controllers\UsersController@update');
        Route::delete('users/{user}', 'Wnx\LaravelStats\Tests\Stubs\Controllers\UsersController@destroy');

        $result = app(NumberOfRoutes::class)->get();

        $this->assertEquals(8, $result);
    }

    #[Test]
    public function it_only_counts_unique_routes(): void
    {
        Route::get('users', 'Wnx\LaravelStats\Tests\Stubs\Controllers\UsersController@index');
        Route::get('users', 'Wnx\LaravelStats\Tests\Stubs\Controllers\UsersController@create');

        $result = app(NumberOfRoutes::class)->get();

        $this->assertEquals(2, $result);
    }
}
