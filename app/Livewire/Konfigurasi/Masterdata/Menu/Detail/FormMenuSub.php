<?php

namespace App\Livewire\Konfigurasi\Masterdata\Menu\Detail;

use App\Models\Menu;
use App\Models\MenuSub;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\On;
use Livewire\Attributes\Rule;
use Livewire\Component;
use Spatie\Permission\Models\Role;

class FormMenuSub extends Component
{
    public $id, $flag = 'tambah';

    #[Rule('required|string')]
    public $name;

    #[Rule('required|array')]
    public array $roles = [1];

    public $menu_id;

    public function toggleRoles($value)
    {
        if (in_array($value, $this->roles)) {
            $this->roles = array_diff($this->roles, [$value]);
        } else {
            $this->roles[] = $value;
        }
    }

    public function submit(): void
    {
        $this->validate();
        DB::transaction(function () {

            $data = [
                'name' => $this->name,
                'menu_id' => $this->menu_id,
                'index_sort' => MenuSub::get()->count(),
                'roles' => json_encode($this->roles),
                'user_id' => Auth::id(),
            ];

            $menu_sub = MenuSub::find($this->id) ?? MenuSub::create($data);

            if ($this->flag === 'update') {
                foreach ($data as $k => $v) {
                    if ($k === 'user_id') continue;
                    $menu_sub->$k = $v;
                }
                $menu_sub->user_id_update = Auth::id();
                $menu_sub->save();
            }

            $this->dispatch('success', "Menu Sub Berhasil di " . $this->flag === 'update' ? "Tambah" :  "Update");
            $this->reset('name', 'flag', 'id', 'roles');
        });
    }

    #[On('konfigurasi.masterdata.menu.detail.delete')]
    public function delete($id, $flag)
    {
        $menu = MenuSub::find($id);
        if (!$menu) {
            $this->dispatch('error', 'Menu Sub tidak ditemukan.');
            return;
        }

        if ($flag === 'confirm') {
            $this->dispatch('swal-confirm', $id, 'konfigurasi.masterdata.menu.detail.delete', ['text' => "Data Menu Sub \"{$menu->name}\" yang dihapus tidak dapat dikembalikan!"]);
            return;
        }

        $menu->delete();
        $this->dispatch('success', "Menu Sub \"{$menu->name}\" berhasil di delete.");
    }

    #[On('konfigurasi.masterdata.menu.detail.show')]
    public function showModal($id): void
    {
        if (is_null($id)) {
            $this->reset('name', 'flag', 'id', 'roles');
            return;
        };


        $this->flag = 'update';
        $menu_sub = MenuSub::find($id);

        $this->id = $menu_sub->id;
        $this->name = $menu_sub->name;
        $this->roles = json_decode($menu_sub->roles, true);
    }

    public function mount(Menu $menu)
    {
        $this->menu_id = $menu->id;
    }

    public function render()
    {
        $data_roles = Role::all();
        return view('livewire.konfigurasi.masterdata.menu.detail.form-menu-sub', compact('data_roles'));
    }

    public function updated(): void
    {
        $this->resetErrorBag();
        $this->resetValidation();
    }
}
