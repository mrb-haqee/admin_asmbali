<?php

namespace App\Livewire\Konfigurasi\Masterdata\User;

use App\Models\User;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Livewire\Component;
use Livewire\WithPagination;

class DaftarUser extends Component
{
    use WithPagination;

    public $search = '';
    public $range, $page = 1;
    protected $paginationTheme = 'bootstrap';

    public function mount()
    {
        $this->range = date('Y-m-d', strtotime('-1 month')) . ' - ' . date('Y-m-d');
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingRange()
    {
        $this->resetPage();
    }

    public function render()
    {
        $dataDaftar = User::paginate(6);

        return view('livewire.konfigurasi.masterdata.user.daftar-user', ['dataDaftar' => $dataDaftar]);
    }
}
