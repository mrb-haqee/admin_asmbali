<?php

namespace App\Livewire\Konfigurasi\Aksesibilitas\Roles;

use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Livewire\Attributes\On;
use Livewire\Attributes\Rule;
use Livewire\Component;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class DataRoles extends Component
{
    public $flag = 'tambah';

    #[Rule('required|string')]
    public string $name = '';

    public int $id = 0;

    #[Rule('required|array')]
    public $checked_permissions = [];

    public $check_all;

    public function setForm($id)
    {
        if (!$role = Role::find($id)) {
            $this->reset();
            return;
        }

        $this->flag = 'update';
        $this->id = $role->id;
        $this->name = $role->name;
        $this->checked_permissions = $role->permissions->pluck('name');
    }

    #[On('aksesibilitas.roles.delete')]
    public function delete($id, $flag)
    {
        $role = Role::find($id);
        if (!$role) {
            $this->dispatch('error', 'Role tidak ditemukan.');
            return;
        }

        if (!app()->runningUnitTests() && $flag === 'confirm') {
            $this->dispatch('swal-confirm', $id, 'aksesibilitas.roles.delete', ['text' => "Data role {$role->name} yang dihapus tidak dapat dikembalikan"]);
            return;
        }

        $role->delete();
        $this->dispatch('success', 'Role has been deleted successfully');
    }


    public function submit()
    {
        $this->validate();
        DB::transaction(function () {
            $role = Role::find($this->id) ?? new Role();

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

            $this->dispatch('success', $this->id ? 'Role updated' : 'Role created');
            $this->reset();
        });
    }

    public function checkAll()
    {
        $this->checked_permissions = $this->check_all ? Permission::all()->pluck('name') : [];
    }

    #[On('success', 'swal')]
    public function render()
    {
        $permissions_by_group = [];
        foreach (Permission::all() ?? [] as $permission) {
            $ability = Str::after($permission->name, ' ');
            $permissions_by_group[$ability][] = $permission;
        }
        $roles = Role::with('permissions')->get();
        return view('livewire.konfigurasi.aksesibilitas.roles.data-roles', compact('roles', 'permissions_by_group'));
    }

    public function updated()
    {
        $this->resetErrorBag();
        $this->resetValidation();
    }
}
