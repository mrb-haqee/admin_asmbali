<?php

namespace App\Livewire\Konfigurasi\Aksesibilitas\Roles;

use Livewire\Attributes\On;
use Livewire\Component;
use Spatie\Permission\Models\Role;

class DaftarRoles extends Component
{
    #[On('delete')]
    public function delete($flag, $id)
    {
        if (!$role = Role::find($id)) {
            $this->dispatch('error', 'Role tidak ditemukan.');
            return;
        }

        if (!app()->runningUnitTests() && $flag === 'confirm') {
            $this->dispatch('swal-confirm', [DaftarRoles::class, 'delete'], ['data' => $id, 'text' => "Data role {$role->name} yang dihapus tidak dapat dikembalikan"]);
            return;
        }

        $role->delete();
        $this->dispatch('swal', 'User berhasil dihapus dari Role.');
    }

    #[On('refresh')]
    public function render()
    {
        $roles = Role::with('permissions')->get();
        $pathForm = lwClassToKebab(FormRoles::class);
        return view('livewire.konfigurasi.aksesibilitas.roles.daftar-roles', compact('roles', 'pathForm'));
    }
}
