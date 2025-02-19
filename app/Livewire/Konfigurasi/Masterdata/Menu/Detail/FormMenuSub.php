<?php

namespace App\Livewire\Konfigurasi\Masterdata\Menu\Detail;

use App\Models\MenuSub;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class FormMenuSub extends Component
{


    public $user_id;

    public $id, $name, $flag = 'tambah';
    public $menu;

    public function submit(): void
    {
        $this->validate([
            'name' => 'required|string',
        ], [
            'name.required' => 'Nama wajib diisi.',
        ]);

        // dd($this->menu->id);


        DB::transaction(function () {

            $data = [
                'name' => $this->name,
                'menu_id' => $this->menu->id,
                'index_sort' => MenuSub::get()->count(),
                'user_id' => $this->user_id,
            ];

            $menu_sub = MenuSub::find($this->id) ?? MenuSub::create($data);

            if ($this->flag === 'update') {
                foreach ($data as $k => $v) {
                    if ($k === 'user_id') continue;
                    $menu_sub->$k = $v;
                }
                $menu_sub->user_id_update = $this->user_id;
                $menu_sub->save();
            }

            if ($this->flag === 'update') {
                $this->dispatch('success', __('Menu Sub updated'));
            } else {
                $this->dispatch('success', __('Menu Sub added'));
            }
            $this->dispatch('proses-selesai');
            $this->reset('name', 'flag', 'id');
        });
    }

    public function delete($id)
    {
        MenuSub::destroy($id);
        $this->dispatch('swal', __('Menu Sub removed'), 'success');
        $this->dispatch('proses-selesai');
    }

    public function update($id): void
    {
        $this->flag = 'update';
        $menu_sub = MenuSub::find($id);

        $this->id = $menu_sub->id;
        $this->name = $menu_sub->name;

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

    public function mount($menu)
    {
        $this->menu = $menu;
    }

    public function render()
    {
        return view('livewire.konfigurasi.masterdata.menu.detail.form-menu-sub');
    }
}
