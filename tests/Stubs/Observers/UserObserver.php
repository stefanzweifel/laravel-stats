<?php

namespace Wnx\LaravelStats\Tests\Stubs\Observers;

use Wnx\LaravelStats\Tests\Stubs\Models\User;

class UserObserver
{
    /**
     * Handle the user "created" event.
     *
     * @param  \App\User  $user
     */
    public function created(User $user): void
    {
        //
    }

    /**
     * Handle the user "updated" event.
     *
     * @param  \App\User  $user
     */
    public function updated(User $user): void
    {
        //
    }

    /**
     * Handle the user "deleted" event.
     *
     * @param  \App\User  $user
     */
    public function deleted(User $user): void
    {
        //
    }

    /**
     * Handle the user "restored" event.
     *
     * @param  \App\User  $user
     */
    public function restored(User $user): void
    {
        //
    }

    /**
     * Handle the user "force deleted" event.
     *
     * @param  \App\User  $user
     */
    public function forceDeleted(User $user): void
    {
        //
    }
}
