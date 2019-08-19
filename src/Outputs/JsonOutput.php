<?php

namespace Wnx\LaravelStats\Outputs;

use Illuminate\Console\OutputStyle;
use Wnx\LaravelStats\Project;
use Wnx\LaravelStats\Statistics\JsonBuilder;
use Wnx\LaravelStats\Statistics\ProjectStatistics;

/**
 * @deprecated
 */
class JsonOutput
{
    /**
     * Console output.
     *
     * @var \Illuminate\Console\OutputStyle
     */
    protected $output;

    /**
     * Create new instance of JsonOutput.
     *
     * @param \Illuminate\Console\OutputStyle $output
     */
    public function __construct(OutputStyle $output)
    {
        $this->output = $output;
    }

    public function render(Project $project)
    {
        $jsonStructure = [
            'components' => [
                [
                    'name' => 'String',
                    'number_of_classes' => 0,
                    'methods' => 0,
                    'methods_per_class' => 0,
                    'loc' => 0,
                    'lloc' => 0,
                    'lloc_per_method' => 0,

                    // If isVerbose
                    'classes' => [
                        [
                            'name' => 'FQDN',
                            'methods' => 0,
                            'methods_per_class' => 0,
                            'loc' => 0,
                            'lloc' => 0,
                            'lloc_per_method' => 0,
                        ]
                    ],

                ],
            ],
            'total' => [
                'number_of_classes' => 0,
                'methods' => 0,
                'methods_per_class' => 0,
                'loc' => 0,
                'lloc' => 0,
                'lloc_per_method' => 0,
            ],
            'meta' => [
                'code_lloc' => 0,
                'test_lloc' => 0,
                'code_to_test_ratio' => 0,
                'number_of_routes' => 0,
            ]
        ];

        $this->output->text(json_encode($jsonStructure, JSON_PRETTY_PRINT));

    }

    /**
     * Render output from given statistics.
     *
     * @param  \Wnx\LaravelStats\Statistics\ProjectStatistics $statistics
     * @return void
     */
    public function renderOld(ProjectStatistics $statistics): void
    {
        $statsJson = (new JsonBuilder($statistics))->get();

        $this->output->text($statsJson);
    }
}
