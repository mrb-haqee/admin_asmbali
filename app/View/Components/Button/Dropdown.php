<?php

namespace App\View\Components\Button;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Dropdown extends Component
{
    /**
     * Create a new component instance.
     */
    public $trigger, $name;
    public function __construct($name = 'Action', $trigger = 'click')
    {
        //
        $this->trigger = $trigger;
        $this->name = $name;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {

        $trigger = $this->trigger;
        $name = $this->name;
        return view('components.button.dropdown', compact('trigger', 'name'));
    }
}
