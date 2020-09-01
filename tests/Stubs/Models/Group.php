<?php

namespace Wnx\LaravelStats\Tests\Stubs\Models;

use Illuminate\Database\Eloquent\Relations\HasMany;

class Group extends BaseModel
{
    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }
}
