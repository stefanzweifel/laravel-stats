<?php

namespace Wnx\LaravelStats\Statistics;

class NumberOfRoutes
{
    public function get() : int
    {
        return rescue(function () {
            return collect(app('router')->getRoutes())->count();
        }, 0);
    }
}
