<?php

namespace App\Livewire\Konfigurasi\Aksesibilitas\Permission;

use Illuminate\Database\QueryException;
use Livewire\Attributes\On;
use Livewire\Attributes\Rule;
use Livewire\Component;
use Spatie\Permission\Models\Permission;

class FormPermission extends Component
{
    #[Rule('required|string')]
    public $name;
    public $id = 0;

    #[On('aksesibilitas.permission.from')]
    public function showForm($id)
    {
        $permission = Permission::find($id);
        if (!$permission) {
            $this->reset('id', 'name');
            return;
        }

        $this->id = $id;
        $this->name = $permission->name;
    }

    #[On('aksesibilitas.permission.delete')]
    public function delete($id, $flag)
    {
        $permission = Permission::find($id);
        if (!$permission) {
            $this->dispatch('error', 'Permission tidak ditemukan.');
            return;
        }

        if ($flag === 'confirm') {
            $this->dispatch('swal-confirm', $id, 'aksesibilitas.permission.delete', ['text' => "Data Permission \"{$permission->name}\" yang dihapus tidak dapat dikembalikan"]);
            return;
        }

        $permission->delete();
        $this->dispatch('success', 'Permission has been deleted successfully');
    }

    public function submit(): void
    {
        if ($this->id !== 0) {
            $permission = Permission::find($this->id);
        } else {
            $permission = new Permission();
        }

        $permission->name = strtolower(trim($this->name));


        try {
            $permission->save();

            $this->dispatch('success', $this->id ? ' Permission updated' : ' Permission created');
            $this->reset('id');
        } catch (QueryException $e) {
            if ($e->errorInfo[1] == 1062) { // Duplicate entry error code
                $this->dispatch('error', 'Nama Permission sudah digunakan.');
                return;
            }
        }
    }

    public function render()
    {
        return view('livewire.konfigurasi.aksesibilitas.permission.form-permission');
    }

    public function updated()
    {
        $this->resetErrorBag();
        $this->resetValidation();
    }
}
