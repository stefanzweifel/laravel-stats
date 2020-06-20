<?php

namespace Wnx\LaravelStats\Tests\Stubs\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Group extends Model
{
    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }
}
