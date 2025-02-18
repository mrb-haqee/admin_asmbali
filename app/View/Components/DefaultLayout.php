<?php

namespace App\View\Components;

use Illuminate\View\Component;

class DefaultLayout extends Component
{
    public $pageDetail;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($pageDetail = false)
    {
        // Init layout file
        app(config('settings.KT_THEME_BOOTSTRAP.default'))->init();
        $this->pageDetail = $pageDetail;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        // See also starterkit/app/Core/Bootstrap/BootstrapDefault.php
        return view(config(key: 'settings.KT_THEME_LAYOUT_DIR') . '._default');
    }
}
