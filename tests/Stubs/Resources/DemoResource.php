<?php

namespace Wnx\LaravelStats\Tests\Stubs\Resources;

if (! class_exists(Illuminate\Http\Resources\Json\Resource::class)) {
    return;
}

use Illuminate\Http\Resources\Json\Resource;

class DemoResource extends Resource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request
     *
     * @return array
     */
    public function toArray($request)
    {
        return parent::toArray($request);
    }
}
