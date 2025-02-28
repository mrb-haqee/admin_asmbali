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

class FormRoles extends Component
{
    #[Rule('required|string')]
    public string $name = '';
    #[Rule('required|array')]
    public $checked_permissions = [];
    public int $id = 0;
    public $check_all;

    #[On('setForm')]
    public function setForm($id)
    {
        if (!$role = Role::find($id)) {
            $this->reset();
            return;
        }

        $this->id = $role->id;
        $this->name = $role->name;
        $this->checked_permissions = $role->permissions->pluck('name');
    }

    #[On('delete')]
    public function delete($id, $flag)
    {
        if (!$role = Role::find($id)) {
            $this->dispatch('error', 'Role tidak ditemukan.');
            return;
        }

        if (!app()->runningUnitTests() && $flag === 'confirm') {
            $this->dispatch('swal-confirm', $id, 'aksesibilitas.roles.delete', ['text' => "Data role {$role->name} yang dihapus tidak dapat dikembalikan"]);
            return;
        }

        $role->delete();
        $this->dispatch('success', 'Role berhasil didelete.');
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
            $this->dispatch('refresh')->to(DaftarRoles::class);
            $this->reset();
        });
    }

    public function checkAll()
    {
        $this->checked_permissions = $this->check_all ? Permission::all()->pluck('name') : [];
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

    public function updated()
    {
        $this->resetErrorBag();
        $this->resetValidation();
    }
}
