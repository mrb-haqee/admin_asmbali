<?php

namespace App\Livewire\Konfigurasi\Masterdata\Menu;

use App\Models\Menu;
use Livewire\Attributes\On;
use Livewire\Component;
use Spatie\Permission\Models\Permission;

use function Laravel\Prompts\form;

class DaftarMenu extends Component
{
    public $search = '';

    #[On('delete')]
    public function delete($flag, $id)
    {
        if (!$menu = Menu::find($id)) {
            $this->dispatch('error', 'Menu tidak ditemukan.');
            return;
        }

        if (!app()->runningUnitTests() && $flag === 'confirm') {
            $this->dispatch('swal-confirm', [DaftarMenu::class, 'delete'], ['data' => $id, 'text' => "Data Menu \"{$menu->name}\" yang dihapus tidak dapat dikembalikan!"]);
            return;
        }

        $permissions = Permission::where('name', 'like', "%{$menu->group}.{$menu->name}%")->get();
        $permissions->each(fn($p) => $p->delete());

        $menu->delete();
        $this->dispatch('success', "Menu \"{$menu->name}\" berhasil di delete.");
    }

    #[On('refresh')]
    public function render()
    {
        $dataDaftar = Menu::query();

        if (!empty($this->search)) {
            $dataDaftar->where('name', 'like', "%{$this->search}%")
                ->orWhere('group', 'like', "%{$this->search}%");
        } else {
            if (!empty($this->range) && str_contains($this->range, ' - ')) {
                [$startDate, $endDate] = explode(' - ', $this->range);
                // $query->whereBetween('created_at', [$startDate, $endDate]);
            }
        }

        $pathForm = lwClassToKebab(FormMenu::class);
        $dataDaftar = $dataDaftar->orderBy('group')->orderBy('index_sort')->get();
        return view('livewire.konfigurasi.masterdata.menu.daftar-menu', compact('dataDaftar', 'pathForm'));
    }
}
