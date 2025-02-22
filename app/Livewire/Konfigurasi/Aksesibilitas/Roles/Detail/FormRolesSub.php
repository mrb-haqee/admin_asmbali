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

    // #[On('aksesibilitas.roles.detail.form-roles-sub.select2multiple')]
    public function select2multiple($users)
    {
        $this->users = $users;
    }

    public function submit(): void
    {
        DB::transaction(function () {

            $users = User::whereIn('id', $this->users)->get();

            if (!$users->count()) {
                $this->dispatch('error', __('Tidak ada user yang dipilih'));
                return;
            }

            foreach ($users as $user) {
                $user->assignRole($this->role);
            }

            $this->dispatch('success', __('Berhasil menambahkan role'));

            $this->role->refresh();
            $this->reset('users');

            $this->dispatch('reload-select-2-multiple');
        });
    }

    public function mount(Role $role)
    {
        $this->role = $role;
    }

    #[On('success')]
    public function render()
    {
        $dataDaftar = User::doesntHave('roles')->get();
        return view('livewire.konfigurasi.aksesibilitas.roles.detail.form-roles-sub', compact('dataDaftar'));
    }
}
