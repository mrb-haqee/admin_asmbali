<?php

namespace App\Livewire\Konfigurasi\Aksesibilitas\Roles;

use Illuminate\Database\Eloquent\Collection;
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
    public $checked_permissions;
    public $check_all;
    public Role $role;
    public Collection $permissions;



    #[On('aksesibilitas.roles.show')]
    public function showForm($id)
    {

        if ($id === null) {
            $this->role = new Role;
            $this->name = '';
            return;
        }

        $role = Role::where('id', $id)->first();
        if (!$role) {
            $this->dispatch('error', 'The selected role is not found');
            return;
        }

        $this->role = $role;

        $this->name = $this->role->name;
        $this->checked_permissions = $this->role->permissions->pluck('name');
    }

    #[On('aksesibilitas.roles.delete')]
    public function deleteRole($id)
    {

        $role = Role::where('id', $id)->first();

        if (!$role) {
            $this->dispatch('error', 'Role tidak ditemukan.');
            return;
        }

        $role->delete();

        $this->dispatch('success', 'Role has been deleted successfully');
    }


    public function submit()
    {
        $this->validate();

        $this->role->name = $this->name;
        if ($this->role->isDirty()) {
            $this->role->save();
        }

        $this->role->syncPermissions($this->checked_permissions);

        $this->reset('name', 'checked_permissions');
        $this->dispatch('success', 'Permissions for ' . ucwords($this->role->name) . ' role updated');
    }



    public function checkAll()
    {
        if ($this->check_all) {
            $this->checked_permissions = $this->permissions->pluck('name');
        } else {
            $this->checked_permissions = [];
        }
    }

    public function mount()
    {
        $this->permissions = Permission::all();

        $this->checked_permissions = [];
    }

    public function render()
    {
        $permissions_by_group = [];
        foreach ($this->permissions ?? [] as $permission) {
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
