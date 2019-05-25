<?php

declare(strict_types=1);

namespace Wnx\LaravelStats\Tests\Stubs\Policies;

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
