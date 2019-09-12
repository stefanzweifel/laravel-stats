<?php

namespace Wnx\LaravelStats\Tests\Stubs\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class DemoCollectionResource extends ResourceCollection
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
