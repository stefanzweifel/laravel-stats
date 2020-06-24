<?php declare(strict_types=1);

namespace Wnx\LaravelStats\ShareableMetrics\Metrics;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\File;
use Wnx\LaravelStats\Contracts\CollectableMetric;

class NumberOfPackages extends Metric implements CollectableMetric
{
    public function name(): string
    {
        return 'packages';
    }

    public function value()
    {
        $composerJson = json_decode(File::get(base_path('composer.json')), true);

        $dependencies = Arr::get($composerJson, 'require', []);
        $devDependencies = Arr::get($composerJson, 'require-dev', []);

        return [
            'require' => $dependencies,
            'require-dev' => $devDependencies,
        ];
    }
}
