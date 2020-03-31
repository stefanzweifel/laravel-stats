<?php

namespace Wnx\LaravelStats\Tests\Stubs\CustomCasts;

use Illuminate\Contracts\Database\Eloquent\CastsAttributes;

class StubCast implements CastsAttributes
{
    public function get($model, $key, $value, $attributes)
    {
        return 'value';
    }

    public function set($model, $key, $value, $attributes)
    {
        return 'value';
    }
}
