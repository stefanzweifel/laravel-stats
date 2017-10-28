<?php

namespace Wnx\LaravelStats\Tests\Stubs\ServiceProviders;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;
use Wnx\LaravelStats\Tests\Stubs\EventListeners\DemoEventListener;
use Wnx\LaravelStats\Tests\Stubs\Events\DemoEvent;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        DemoEvent::class => [
            DemoEventListener::class
        ]
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();
    }
}
