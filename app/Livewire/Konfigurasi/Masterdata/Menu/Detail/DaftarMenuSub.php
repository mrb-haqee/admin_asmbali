<?php

namespace App\Livewire\Konfigurasi\Masterdata\Menu\Detail;

use App\Models\Menu;
use App\Models\MenuSub;
use Livewire\Attributes\On;
use Livewire\Component;
use Spatie\Permission\Models\Permission;

class DaftarMenuSub extends Component
{
    public $search = '', $menu;

    #[On('delete')]
    public function delete($flag, $id)
    {
        if (!$menuSub = MenuSub::find($id)) {
            $this->dispatch('error', 'Menu Sub tidak ditemukan.');
            return;
        }

        if (!app()->runningUnitTests() && $flag === 'confirm') {
            $this->dispatch('swal-confirm', [DaftarMenuSub::class, 'delete'], ['data' => $id, 'text' => "Data Menu \"{$menuSub->name}\" yang dihapus tidak dapat dikembalikan!"]);
            return;
        }

        $permissions = Permission::where('name', 'like', "%{$this->menu->group}{$this->menu->name}.{$menuSub->name}%")->get();
        $permissions->each(fn($p) => $p->delete());

        $menuSub->delete();
        $this->dispatch('success', "Menu Sub berhasil di delete.");
    }

    public function mount(Menu $menu)
    {
        $this->menu = $menu;
    }

    #[On('refresh')]
    public function render()
    {
        $dataDaftar = MenuSub::query();
        $dataDaftar->where('menu_id', $this->menu->id);

        if (!empty($this->search)) {
            $dataDaftar->where('name', 'like', "%{$this->search}%");
        } else {
            if (!empty($this->range) && str_contains($this->range, ' - ')) {
                [$startDate, $endDate] = explode(' - ', $this->range);
                // $query->whereBetween('created_at', [$startDate, $endDate]);
            }
        }

        $dataDaftar = $dataDaftar->orderBy('index_sort')->get();
        $pathForm = lwClassToKebab(FormMenuSub::class);
        return view('livewire.konfigurasi.masterdata.menu.detail.daftar-menu-sub', compact('dataDaftar', 'pathForm'));
    }
}
