<?php

namespace App\Livewire\Konfigurasi\Masterdata\Menu\Detail;

use App\Models\Menu;
use App\Models\MenuSub;
use Livewire\Attributes\On;
use Livewire\Component;

class DaftarMenuSub extends Component
{
    public string $search;
    public $menu;

    public function mount(Menu $menu)
    {
        $this->menu = $menu;
    }

    #[On('success', 'swal')]
    public function render()
    {
        $dataDaftar = MenuSub::query();
        $dataDaftar->where('menu_id', $this->menu->id);

        if (!empty($this->search)) {
            $dataDaftar->where('name', 'like', "%{$this->search}%");
        } else {
            if (!empty($this->range) && str_contains($this->range, ' - ')) {
                [$startDate, $endDate] = explode(' - ', $this->range);
                // $dataDaftar->whereBetween('created_at', [$startDate, $endDate]);
            }
        }

        $dataDaftar = $dataDaftar->get();
        return view('livewire.konfigurasi.masterdata.menu.detail.daftar-menu-sub', compact('dataDaftar'));
    }
}
