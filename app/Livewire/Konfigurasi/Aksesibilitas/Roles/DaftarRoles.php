<?php

namespace App\Livewire\Konfigurasi\Aksesibilitas\Roles;

use Livewire\Component;
use Spatie\Permission\Models\Role;

class DaftarRoles extends Component
{

    protected $listeners = ['success' => '$refresh'];

    public function render()
    {
        $roles = Role::with('permissions')->get();
        return view('livewire.konfigurasi.aksesibilitas.roles.daftar-roles', compact('roles'));
    }
}
