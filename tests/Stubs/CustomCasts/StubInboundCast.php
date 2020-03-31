<?php

namespace Wnx\LaravelStats\Tests\Stubs\CustomCasts;

use Illuminate\Contracts\Database\Eloquent\CastsInboundAttributes;

class StubInboundCast implements CastsInboundAttributes
{
    public function set($model, $key, $value, $attributes)
    {
        return 'value';
    }
}
