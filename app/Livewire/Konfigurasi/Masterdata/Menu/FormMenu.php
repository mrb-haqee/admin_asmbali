<?php

namespace App\Livewire\Konfigurasi\Masterdata\Menu;

use App\Models\Menu;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class FormMenu extends Component
{

    public $user_id;

    public $menu_id, $group, $name, $option, $flag = 'tambah';

    public function submit(): void
    {
        $this->validate([
            'group' => 'required|string',
            'name' => 'required|string',
        ], [
            'group.required' => 'Group wajib diisi.',
            'name.required' => 'Nama wajib diisi.',
        ]);

        DB::transaction(function () {

            $data = [
                'group' => $this->group,
                'name' => $this->name,
                'option' => $this->option ? '__YES__' : '__NO__',
                'index_sort' => Menu::where('group', $this->group)->count(),
            ];

            $menu = Menu::find($this->menu_id) ?? Menu::create($data);

            if ($this->flag === 'update') {
                foreach ($data as $k => $v) {
                    $menu->$k = $v;
                }
                $menu->user_id_update = $this->user_id;
                $menu->save();
            } else {
            }

            if ($this->flag === 'update') {
                $this->dispatch('success', __('Menu updated'));
            } else {
                $this->dispatch('success', __('Menu added'));
            }
            $this->dispatch('proses-selesai');
            $this->reset();
        });
    }

    public function delete($id)
    {
        Menu::destroy($id);
        $this->dispatch('swal', __('Menu berhasil dihapus'), 'success');
        $this->dispatch('proses-selesai');
    }

    public function update($id): void
    {
        $this->flag = 'update';
        $menu = Menu::find($id);

        $this->menu_id = $menu->id;
        $this->group = $menu->group;
        $this->name = $menu->name;
        $this->option = $menu->option === '__YES__' ? true : false;

        $this->dispatch('select2');
    }

    public function resetFlag(): void
    {
        $this->flag === 'update' && $this->reset();
    }
    public function hydrate(): void
    {
        $this->resetErrorBag();
        $this->resetValidation();

        $this->user_id = Auth::user()->id;
    }

    public function render()
    {
        return view('livewire.konfigurasi.masterdata.menu.form-menu');
    }
}
