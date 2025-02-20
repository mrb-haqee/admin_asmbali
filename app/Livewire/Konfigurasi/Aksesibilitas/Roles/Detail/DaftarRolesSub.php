<?php

namespace App\Livewire\Konfigurasi\Aksesibilitas\Roles\Detail;

use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;
use Spatie\Permission\Models\Role;

class DaftarRolesSub extends Component
{

    public Role $role;

    protected $listeners = [
        'success' => '$refresh',
        'error' => '$refresh',
        'swal' => '$refresh',
    ];

    #[On('aksesibilitas.roles.detail.delete')]
    public function deleteRole($user_id)
    {
        $user = User::find($user_id);
        if ($user) {
            $user->roles()->detach();
            $this->dispatch('swal', 'Role has been deleted successfully');
        } else {
            $this->dispatch('error', 'User not found');
        }
    }

    public function mount(Role $role)
    {
        $this->role = $role;
    }

    public function render()
    {
        $dataDaftar = User::whereIn('id', $this->role->users->pluck('id'))->get();

        return view('livewire.konfigurasi.aksesibilitas.roles.detail.daftar-roles-sub', compact('dataDaftar'));
    }
}
