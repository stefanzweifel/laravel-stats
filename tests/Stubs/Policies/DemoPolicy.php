<?php

namespace Wnx\LaravelStats\Tests\Stubs\Policies;

use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class DemoPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }
}
