<?php

namespace App\Livewire\Konfigurasi\Masterdata\Menu\Detail;

use App\Models\Menu;
use Livewire\Component;

class MenuSubIndex extends Component
{

    public $id, $menu;

    public function mount($id)
    {
        $this->id = $id;
        $this->menu = Menu::find($id);
    }

    public function render()
    {
        return view('livewire.konfigurasi.masterdata.menu.detail.index');
    }
}
