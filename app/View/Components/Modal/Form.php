<?php

namespace App\View\Components\Modal;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Form extends Component
{
    public $id;
    public $flag;

    /**
     * Create a new component instance.
     *
     * @param string $id Modal
     * @param string $title
     */
    public function __construct(string $id = 'default', string $flag = 'tambah')
    {
        $this->id = $id;
        $this->flag = $flag;
    }


    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.modal.form', [
            'id' => $this->id,
            'flag' => $this->flag,
        ]);
    }
}
