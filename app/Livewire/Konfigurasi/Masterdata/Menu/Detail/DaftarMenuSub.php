<?php

namespace App\Livewire\Konfigurasi\Masterdata\Menu\Detail;

use App\Models\Menu;
use App\Models\MenuSub;
use Livewire\Component;

class DaftarMenuSub extends Component
{

    public $search = '';
    public $range;
    public $menu;
    public $dataDaftar;

    public function getDataDaftar()
    {
        $query = MenuSub::query();
        $query->where('menu_id', $this->menu->id);

        // Filter berdasarkan pencarian nama dan grup
        if (!empty($this->search)) {
            $query->where('name', 'like', "%{$this->search}%");
        } else {
            if (!empty($this->range) && str_contains($this->range, ' - ')) {
                [$startDate, $endDate] = explode(' - ', $this->range);
                // $query->whereBetween('created_at', [$startDate, $endDate]);
            }
        }

        $this->dataDaftar = $query->get()->toArray();
    }

    public function updated()
    {
        $this->getDataDaftar();
    }


    public function mount($menu)
    {
        $this->range = date('Y-m-d', strtotime('-1 month')) . ' - ' . date('Y-m-d');
        $this->menu = $menu;
        $this->getDataDaftar();
    }

    public function render()
    {
        return view('livewire.konfigurasi.masterdata.menu.detail.daftar-menu-sub');
    }
}
