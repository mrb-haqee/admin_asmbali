<?php

namespace App\Livewire\Konfigurasi\Aksesibilitas\Roles\Detail;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\On;
use Livewire\Attributes\Rule;
use Livewire\Component;
use Spatie\Permission\Models\Role;

class FormAddUserRoles extends Component
{
    #[Rule(['required'])]
    public array $selectedUsers;
    public Role $role;

    public function submit(): void
    {
        $this->validate();
        DB::transaction(function () {
            $users = User::whereIn('id', $this->selectedUsers)->get();

            foreach ($users as $user) {
                $user->assignRole($this->role);
            }

            $this->dispatch('success', 'Berhasil menambahkan role');

            $this->role->refresh();
            $this->resetExcept('role');

            $this->dispatch('refresh')->to(DaftarRolesSub::class);
        });
    }

    public function mount(Role $role)
    {
        $this->role = $role;
    }

    public function render()
    {
        $users = User::doesntHave('roles')->get();
        return view('livewire.konfigurasi.aksesibilitas.roles.detail.form-add-user-roles', compact('users'));
    }
}
