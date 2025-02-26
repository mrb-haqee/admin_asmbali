<?php

namespace App\Livewire\Konfigurasi\Masterdata\Menu\Detail;

use App\Models\Menu;
use Livewire\Component;

class MenuSubIndex extends Component
{
    public $id;

    public function mount(Menu $menu)
    {
        $this->id = $menu->id;
    }

    public function render()
    {
        $menu  = Menu::find($this->id);
        return view('livewire.konfigurasi.masterdata.menu.detail.index', compact('menu'));
    }
}
