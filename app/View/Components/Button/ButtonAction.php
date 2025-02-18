<?php

namespace App\View\Components\Button;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class ButtonAction extends Component
{
    /**
     * Create a new component instance.
     */
    public $data = [];
    public $handle = [];

    public function __construct($data = [], $handle = [])
    {
        $this->data = $data;
        $this->handle = $handle;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.button.button-action', ['data' => $this->data, 'handle' => $this->handle]);
    }
}
