<?php

namespace Wnx\LaravelStats\Tests\Stubs\BladeComponents;

use Illuminate\View\Component;

class StubBladeComponent extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.stub-blade-component');
    }
}
