<?php

namespace App\Livewire\Konfigurasi\Aksesibilitas\Roles;

use Livewire\Attributes\On;
use Livewire\Component;
use Spatie\Permission\Models\Role;

class DaftarRoles extends Component
{


    public $listeners = ['success' => '$refresh', 'error' => '$refresh', 'swal' => '$refresh'];

    #[On('success', 'error', 'swal')]
    public function render()
    {
        $roles = Role::with('permissions')->get();
        return view('livewire.konfigurasi.aksesibilitas.roles.daftar-roles', compact('roles'));
    }
}
