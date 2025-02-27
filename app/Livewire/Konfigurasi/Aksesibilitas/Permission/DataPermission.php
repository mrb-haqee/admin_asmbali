<?php

namespace App\Livewire\Konfigurasi\Aksesibilitas\Permission;

use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;
use Spatie\Permission\Models\Permission;

class DataPermission extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $search = '';

    public function render()
    {
        $dataDaftar = Permission::where('name', 'like', '%' . $this->search . '%')->paginate(10);
        return view('livewire.konfigurasi.aksesibilitas.permission.data-permission', compact('dataDaftar'));
    }
}
