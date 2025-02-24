<?php

namespace App\Livewire\Konfigurasi\Aksesibilitas\Permission;

use Livewire\Attributes\On;
use Livewire\Component;
use Spatie\Permission\Models\Permission;

class DaftarPermission extends Component
{

    public $check_all;
    public $checked_permissions = [];

    public function toggleChecked($id)
    {
        if (in_array($id, $this->checked_permissions)) {
            $this->checked_permissions = array_diff($this->checked_permissions, [$id]);
        } else {
            $this->checked_permissions[] = $id;
        }
    }

    #[On('aksesibilitas.permission.delete-checked')]
    public function deleteRoleChecked($flag)
    {

        if ($flag === 'confirm') {
            $this->dispatch('swal-confirm', $this->checked_permissions, 'aksesibilitas.permission.delete-checked', ['text' => "Data Permission yang dihapus tidak dapat dikembalikan"]);
            return;
        }

        foreach ($this->checked_permissions as $id) {
            $permission = Permission::find($id);
            $permission->delete();
        }

        $this->dispatch('swal', 'Permission has been deleted successfully');
        $this->reset('checked_permissions', 'check_all');
    }

    #[On('success', 'swal')]
    public function render()
    {
        $dataDaftar = Permission::all();
        return view('livewire.konfigurasi.aksesibilitas.permission.daftar-permission', compact('dataDaftar'));
    }
}
