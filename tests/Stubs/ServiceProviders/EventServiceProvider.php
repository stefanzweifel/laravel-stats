<?php

namespace Wnx\LaravelStats\Tests\Stubs\ServiceProviders;

use Wnx\LaravelStats\Tests\Stubs\EventListeners\UserEventSubscriber;
use Wnx\LaravelStats\Tests\Stubs\Events\DemoEvent;
use Wnx\LaravelStats\Tests\Stubs\EventListeners\DemoEventListener;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        DemoEvent::class => [
            DemoEventListener::class,
        ],
    ];

    protected $subscribe = [
        UserEventSubscriber::class,
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
