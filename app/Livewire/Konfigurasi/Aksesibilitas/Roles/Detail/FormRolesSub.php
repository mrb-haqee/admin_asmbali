<?php

namespace App\Livewire\Konfigurasi\Aksesibilitas\Roles\Detail;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\On;
use Livewire\Component;
use Spatie\Permission\Models\Role;

class FormRolesSub extends Component
{
    public array $users;
    public Role $role;

    #[On('aksesibilitas.roles.detail.form-roles-sub.select2multiple')]
    public function select2multiple($users)
    {
        $this->users = $users;
    }

    public function submit(): void
    {
        DB::transaction(function () {

            $users = User::whereIn('id', $this->users)->get();

            foreach ($users as $user) {
                $user->assignRole($this->role);
            }

            $this->dispatch('success', __('User updated'));
        });
    }

    public function mount(Role $role)
    {

        $this->role = $role;
    }

    public function render()
    {
        $dataDaftar = User::whereNotIn('id', $this->role->users->pluck('id'))->get();
        return view('livewire.konfigurasi.aksesibilitas.roles.detail.form-roles-sub', compact('dataDaftar'));
    }
}
