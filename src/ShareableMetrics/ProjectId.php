<?php

namespace Wnx\LaravelStats\ShareableMetrics;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class ProjectId
{
    public const RC_FILE = '.laravelstatsrc';

    public function get(): string
    {
        $pathToRcFile = base_path(self::RC_FILE);

        if (File::exists($pathToRcFile)) {
            return File::get($pathToRcFile);
        }

        return tap(Str::uuid()->toString(), function ($projectId) use ($pathToRcFile) {
            File::put($pathToRcFile, $projectId);
        });
    }

}
