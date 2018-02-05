<?php

namespace Wnx\LaravelStats\Statistics;

class JsonBuilder
{
    /**
     * @var ProjectStatistics
     */
    protected $statistics;

    public function __construct(ProjectStatistics $statistics)
    {
        $this->statistics = $statistics;
    }

    public function get()
    {
        $statsJson = [];
        $statsJson['components'] = [];

        // Build Components Block
        foreach ($this->statistics->components() as $component) {
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
            'number_of_classes' => $this->statistics->total()[1],
            'methods' => $this->statistics->total()[2],
            'methods_per_class' => $this->statistics->total()[3],
            'lines' => $this->statistics->total()[4],
            'loc' => $this->statistics->total()[5],
            'loc_per_method' => $this->statistics->total()[6],
        ];

        // Build Meta Block
        $statsJson['meta'] = [
            'code_loc' => (new CodeTestRatio($this->statistics))->getCodeLoc(),
            'test_loc' => (new CodeTestRatio($this->statistics))->getTestLoc(),
            'code_to_test_ratio' => '1:'.(new CodeTestRatio($this->statistics))->getRatio(),
        ];

        return json_encode($statsJson, JSON_PRETTY_PRINT);
    }
}
