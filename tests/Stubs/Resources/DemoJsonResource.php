<?php

namespace Wnx\LaravelStats\Tests\Stubs\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class DemoJsonResource extends JsonResource
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
