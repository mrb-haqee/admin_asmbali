<?php

namespace App\View\Components\Table;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class DataNotFound extends Component
{
    public $colspan;
    /**
     * Create a new component instance.
     */
    public function __construct($colspan = 10)
    {
        //
        $this->colspan = $colspan;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.table.data-not-found', ['colspan' => $this->colspan]);
    }
}
