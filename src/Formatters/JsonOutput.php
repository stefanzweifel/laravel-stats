<?php

namespace Wnx\LaravelStats\Formatters;

use Illuminate\Console\OutputStyle;
use Wnx\LaravelStats\Statistics\CodeTestRatio;
use Wnx\LaravelStats\Statistics\ProjectStatistics;

class JsonOutput
{
    /**
     * Console output.
     *
     * @var \Illuminate\Console\OutputStyle
     */
    protected $output;

    /**
     * Create new instance of TableOutput.
     *
     * @param \Illuminate\Console\OutputStyle $output
     */
    public function __construct(OutputStyle $output)
    {
        $this->output = $output;
    }

    /**
     * Render output from given statistics.
     *
     * @param  ProjectStatistics $statistics
     * @return void
     */
    public function render(ProjectStatistics $statistics)
    {
        $statsJson = [];

        // Build Meta Block
        $statsJson['meta'] = [
            'code_loc' => (new CodeTestRatio($statistics))->getCodeLoc(),
            'test_loc' => (new CodeTestRatio($statistics))->getTestLoc(),
            'code_to_test_ratio' => '1:' . (new CodeTestRatio($statistics))->getRatio()
        ];

        // Build Components Block
        foreach ($statistics->components() as $component) {
            $statsJson['components'][] = [
                'component' => $component['component'],
                'number_of_classes' => $component['number_of_classes'],
                'methods' => $component['methods'],
                'methods_per_class' => $component['methods_per_class'],
                'lines' => $component['lines'],
                'loc' => $component['loc'],
                'loc_per_method' => $component['loc_per_method'],
            ];
        }

        // Build Total Block
        $statsJson['total'] = [
            'number_of_classes' => $statistics->total()[1],
            'methods' => $statistics->total()[2],
            'methods_per_class' => $statistics->total()[3],
            'lines' => $statistics->total()[4],
            'loc' => $statistics->total()[5],
            'loc_per_method' => $statistics->total()[6],
        ];

        return $this->output->text(json_encode($statsJson, JSON_PRETTY_PRINT));
    }
}
