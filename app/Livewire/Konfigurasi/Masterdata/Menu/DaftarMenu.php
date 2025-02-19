<?php

namespace App\Livewire\Konfigurasi\Masterdata\Menu;

use App\Models\Menu;
use Date;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class DaftarMenu extends Component
{
    public $search = '';
    public $range;
    public $dataDaftar;

    public function getDataDaftar()
    {
        $query = Menu::query();

        // Filter berdasarkan pencarian nama dan grup
        if (!empty($this->search)) {
            $query->where('name', 'like', "%{$this->search}%")
                ->orWhere('group', 'like', "%{$this->search}%");
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

    public function mount()
    {
        $this->range = date('Y-m-d', strtotime('-1 month')) . ' - ' . date('Y-m-d');
        $this->getDataDaftar();
    }

    public function render()
    {
        return view('livewire.konfigurasi.masterdata.menu.daftar-menu');
    }
}
