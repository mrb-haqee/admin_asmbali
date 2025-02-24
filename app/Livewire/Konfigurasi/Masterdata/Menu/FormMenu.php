<?php

namespace App\Livewire\Konfigurasi\Masterdata\Menu;

use App\Models\Menu;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\On;
use Livewire\Attributes\Rule;
use Livewire\Component;

class FormMenu extends Component
{

    public $id,  $option, $flag = 'tambah';

    #[Rule('required|string')]
    public $name;

    #[Rule('required|string')]
    public $group;
    public $data_permission = ['view', 'read', 'creat', 'write', 'update', 'delete', 'print'];
    public $checked_permission = ['view'];

    public function togglePermission($value)
    {
        if (in_array($value, $this->checked_permission)) {
            $this->checked_permission = array_diff($this->checked_permission, [$value]);
        } else {
            $this->checked_permission[] = $value;
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

            $this->dispatch('success', $this->flag === 'update' ? __('Menu updated') : __('Menu added'));
            $this->reset();
        });
    }

    #[On('konfigurasi.masterdata.menu.delete')]
    public function delete($id, $flag)
    {

        $menu = Menu::find($id);
        if (!$menu) {
            $this->dispatch('error', 'Permission tidak ditemukan.');
            return;
        }

        if ($flag === 'confirm') {
            $this->dispatch('swal-confirm', $id, 'konfigurasi.masterdata.menu.delete', ['text' => "Data Menu \"{$menu->name}\" yang dihapus tidak dapat dikembalikan"]);
            return;
        }

        $menu->delete();
        $this->dispatch('success', "Menu \"{$menu->name}\" has been deleted successfully");
    }

    #[On('konfigurasi.masterdata.menu.show')]
    public function showModal($id): void
    {
        if (is_null($id)) {
            $this->reset();
            return;
        };

        $this->flag = 'update';
        $menu = Menu::find($id);
        $this->id = $menu->id;
        $this->group = $menu->group;
        $this->name = $menu->name;
        $this->option = $menu->option === '__YES__' ? true : false;
    }

    public function render()
    {
        return view('livewire.konfigurasi.masterdata.menu.form-menu');
    }

    public function updated(): void
    {
        $this->resetErrorBag();
        $this->resetValidation();
    }
}
