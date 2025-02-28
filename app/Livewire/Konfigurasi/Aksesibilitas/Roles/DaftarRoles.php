<?php

namespace App\Livewire\Konfigurasi\Aksesibilitas\Roles;

use Livewire\Attributes\On;
use Livewire\Component;
use Spatie\Permission\Models\Role;

class DaftarRoles extends Component
{
    #[On('refresh')]
    public function render()
    {
        $roles = Role::with('permissions')->get();
        $pathForm = lwClassToKebab(FormRoles::class);
        return view('livewire.konfigurasi.aksesibilitas.roles.daftar-roles', compact('roles', 'pathForm'));
    }
}
