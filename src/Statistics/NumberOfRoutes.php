<?php

namespace Wnx\LaravelStats\Statistics;

use Exception;

class NumberOfRoutes
{
    public function get() : int
    {
        try {
            return collect(app('router')->getRoutes())->count();
        } catch (Exception $exception) {
            return 0;
        }
    }
}
