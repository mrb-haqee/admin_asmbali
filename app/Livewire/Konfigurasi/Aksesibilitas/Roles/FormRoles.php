<?php

namespace App\Livewire\Konfigurasi\Aksesibilitas\Roles;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\QueryException;
use Livewire\Component;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Str;
use Livewire\Attributes\Modelable;
use Livewire\Attributes\On;
use Livewire\Attributes\Rule;

class FormRoles extends Component
{

    #[Rule('required|string')]
    public string $name = '';
    public int $role_id = 0;
    public $checked_permissions;
    public $check_all;

    #[On('aksesibilitas.roles.from')]
    public function showForm($id)
    {
        $role = Role::find($id);
        if (!$role) {
            $this->dispatch('error', 'Role tidak ditemukan.');
            return;
        }

        $this->role_id = $role->id;
        $this->name = $role->name;
        $this->checked_permissions = $role->permissions->pluck('name');
    }

    #[On('aksesibilitas.roles.delete')]
    public function deleteRole($id, $flag)
    {
        $role = Role::find($id);
        if (!$role) {
            $this->dispatch('error', 'Role tidak ditemukan.');
            return;
        }

        if ($flag === 'confirm') {
            $this->dispatch('swal-confirm', $id, 'aksesibilitas.roles.delete', ['text' => "Data role {$role->name} yang dihapus tidak dapat dikembalikan"]);
            return;
        }

        $role->delete();
        $this->dispatch('success', 'Role has been deleted successfully');
    }


    public function submit()
    {
        $this->validate();

        if ($this->role_id !== 0) {
            $role = Role::find($this->role_id);
        } else {
            $role = new Role();
        }

        $role->name = $this->name;

        try {
            if ($role->isDirty()) {
                $role->save();
            }
        } catch (QueryException $e) {
            if ($e->errorInfo[1] == 1062) { // Duplicate entry error code
                $this->dispatch('error', 'Nama Role sudah digunakan.');
                return;
            }
        }

        $role->syncPermissions($this->checked_permissions);

        $this->dispatch('success', $this->role_id ? ' role updated' : ' role created');
        $this->reset('role_id', 'name', 'checked_permissions', 'check_all');
    }



    public function checkAll()
    {
        if ($this->check_all) {
            $this->checked_permissions = Permission::all()->pluck('name');
        } else {
            $this->checked_permissions = [];
        }
    }

    public function mount()
    {
        $this->checked_permissions = [];
    }

    public function render()
    {
        $permissions_by_group = [];
        foreach (Permission::all() ?? [] as $permission) {
            $ability = Str::after($permission->name, ' ');
            $permissions_by_group[$ability][] = $permission;
        }
        return view('livewire.konfigurasi.aksesibilitas.roles.form-roles', compact('permissions_by_group'));
    }

    public function hydrate()
    {
        $this->resetErrorBag();
        $this->resetValidation();
    }
}
