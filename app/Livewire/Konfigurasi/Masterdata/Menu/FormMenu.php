<?php

namespace App\Livewire\Konfigurasi\Masterdata\Menu;

use App\Models\Menu;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\On;
use Livewire\Attributes\Rule;
use Livewire\Component;
use Spatie\Permission\Models\Role;

class FormMenu extends Component
{
    public $id,  $option, $flag = 'tambah';

    #[Rule('required|string')]
    public $name;

    #[Rule('required|string')]
    public $group;

    #[Rule('required|array')]
    public array $checked_roles = [1];

    public function toggleRoles($value)
    {
        if (in_array($value, $this->checked_roles)) {
            $this->checked_roles = array_diff($this->checked_roles, [$value]);
        } else {
            $this->checked_roles[] = $value;
        }
    }

    public function submit()
    {
        $this->validate();

        DB::transaction(function () {

            $data = [
                'group' => $this->group,
                'name' => $this->name,
                'option' => $this->option ? '__YES__' : '__NO__',
                'roles' => json_encode($this->checked_roles),
                'index_sort' => Menu::where('group', $this->group)->count(),
                'user_id' => Auth::id()
            ];

            $menu = Menu::find($this->id) ?? Menu::create($data);

            if ($this->flag === 'update') {
                foreach ($data as $k => $v) {
                    if ($k === 'user_id') continue;
                    $menu->$k = $v;
                }
                $menu->user_id_update = Auth::id();
                $menu->save();
            }

            $this->dispatch('success', "Menu Berhasil di " . $this->flag === 'update' ? "Tambah" :  "Update");
            $this->reset();
        });
    }

    #[On('konfigurasi.masterdata.menu.delete')]
    public function delete($id, $flag)
    {
        $menu = Menu::find($id);
        if (!$menu) {
            $this->dispatch('error', 'Menu tidak ditemukan.');
            return;
        }

        if ($flag === 'confirm') {
            $this->dispatch('swal-confirm', $id, 'konfigurasi.masterdata.menu.delete', ['text' => "Data Menu \"{$menu->name}\" yang dihapus tidak dapat dikembalikan!"]);
            return;
        }

        $menu->delete();
        $this->dispatch('success', "Menu \"{$menu->name}\" berhasil di delete.");
    }

    #[On('konfigurasi.masterdata.menu.show')]
    public function showModal($id): void
    {
        if (is_null($id)) {
            $this->reset();
            return;
        };

        $menu = Menu::find($id);

        $this->flag = 'update';
        $this->id = $menu->id;
        $this->group = $menu->group;
        $this->name = $menu->name;
        $this->option = $menu->option === '__YES__' ? true : false;
        $this->checked_roles = json_decode($menu->roles, true);
    }

    #[On('success', 'swal')]
    public function render()
    {
        $roles = Role::all();
        return view('livewire.konfigurasi.masterdata.menu.form-menu', compact('roles'));
    }

    public function updated(): void
    {
        $this->resetErrorBag();
        $this->resetValidation();
    }
}
