<?php declare(strict_types=1);

namespace Wnx\LaravelStats\ShareableMetrics\Metrics;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\File;
use Wnx\LaravelStats\Contracts\CollectableMetric;

class ComposerPsr4Sources extends Metric implements CollectableMetric
{
    public function name(): string
    {
        return 'composer_psr_4_namespaces';
    }

    public function value()
    {
        $composerJson = json_decode(File::get(base_path('composer.json')), true);

        $psr4 = Arr::get($composerJson, 'autoload.psr-4', []);

        return $psr4;
    }
}
