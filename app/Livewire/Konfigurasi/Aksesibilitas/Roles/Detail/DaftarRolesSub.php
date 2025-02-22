<?php

namespace App\Livewire\Konfigurasi\Aksesibilitas\Roles\Detail;

use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;
use Spatie\Permission\Models\Role;

class DaftarRolesSub extends Component
{
    // ==== Livewire Datatables ====
    use WithPagination;
    public $paginationTheme = 'bootstrap';
    public $perPage = 5;
    public $checked_data = [];

    // ==== Livewire Datatables ====

    public Role $role;

    protected $listeners = [
        'success' => '$refresh',
        'error' => '$refresh',
        'swal' => '$refresh',
    ];

    #[On('aksesibilitas.roles.detail.delete')]
    public function deleteRole($id, $flag)
    {
        $user = User::find($id);

        if (!$user) {
            $this->dispatch('error', 'User tidak ditemukan.');
            return;
        }
        if ($user->id === Auth::id()) {
            $this->dispatch('error', 'Tidak bisa menghapus Akun saat ini.');
            return;
        }

        if ($flag === 'confirm') {
            $this->dispatch('swal-confirm', $id, 'aksesibilitas.roles.detail.delete', ['text' => "Data User roles {$user->name} yang dihapus tidak dapat dikembalikan"]);
            return;
        }

        if ($user) {
            $user->roles()->detach();
            $this->dispatch('swal', 'Role has been deleted successfully');
        } else {
            $this->dispatch('error', 'User not found');
        }
    }

    #[On('aksesibilitas.roles.detail.delete-checked')]
    public function deleteRoleChecked($data, $flag)
    {
        if (in_array(Auth::id(), $this->checked_data)) {
            $this->dispatch('error', 'Tidak bisa menghapus Akun saat ini.');
            return;
        }

        if ($flag === 'confirm') {
            $this->dispatch('swal-confirm', $this->checked_data, 'aksesibilitas.roles.detail.delete-checked', ['text' => "Data User roles yang dihapus tidak dapat dikembalikan"]);
            return;
        }

        foreach ($this->checked_data as $id) {
            $user = User::find($id);
            $user->roles()->detach();
        }

        $this->dispatch('swal', 'Role has been deleted successfully');
        $this->checked_data = [];
    }

    public function toggleChecked($id)
    {
        if (in_array($id, $this->checked_data)) {
            $this->checked_data = array_diff($this->checked_data, [$id]);
        } else {
            $this->checked_data[] = $id;
        }
    }

    public function mount(Role $role)
    {
        $this->role = $role;
    }

    public function render()
    {
        $dataDaftar = User::whereIn('id', $this->role->users->pluck('id'))->paginate($this->perPage);

        return view('livewire.konfigurasi.aksesibilitas.roles.detail.daftar-roles-sub', compact('dataDaftar'));
    }
}
