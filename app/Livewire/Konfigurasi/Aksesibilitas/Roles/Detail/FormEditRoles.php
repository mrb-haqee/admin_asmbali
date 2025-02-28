<?php

namespace App\Livewire\Konfigurasi\Aksesibilitas\Roles\Detail;

use Livewire\Component;
use Spatie\Permission\Models\Role;

class FormEditRoles extends Component
{
    public Role $role;

    public function mount(Role $role)
    {
        $this->role = $role;
    }

    public function render()
    {
        return view('livewire.konfigurasi.aksesibilitas.roles.detail.form-edit-roles');
    }
}
