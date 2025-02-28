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
    public $paginationTheme = 'bootstrap', $perPage = 5;
    public $checked_data = [];
    public Role $role;

    #[On('delete')]
    public function delete($flag, $id)
    {
        if (!$user = User::find($id)) {
            $this->dispatch('error', 'Data tidak ditemukan.');
            return;
        }

        if ($user->id === Auth::id()) {
            $this->dispatch('error', 'Tidak bisa menghapus Akun saat ini.');
            return;
        }

        if ($flag === 'confirm') {
            $this->dispatch('swal-confirm', [DaftarRolesSub::class, 'delete'], ['data' => $id]);
            return;
        }

        $user->roles()->detach();
        $this->dispatch('swal', 'User berhasil dihapus dari Role.');
    }

    #[On('deleteChecked')]
    public function deleteChecked($flag)
    {
        if (in_array(Auth::id(), $this->checked_data)) {
            $this->dispatch('error', 'Tidak bisa menghapus Akun saat ini.');
            return;
        }

        if ($flag === 'confirm') {
            $this->dispatch('swal-confirm', [DaftarRolesSub::class, 'deleteChecked']);
            return;
        }

        foreach ($this->checked_data as $id) {
            $user = User::find($id);
            $user->roles()->detach();
        }

        $this->dispatch('swal', 'User berhasil dihapus dari Role.');
        $this->checked_data = [];
    }

    public function tgCheck($id)
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

    #[On('refresh')]
    public function render()
    {
        $dataDaftar = User::whereIn('id', $this->role->users->pluck('id'))->paginate($this->perPage);

        return view('livewire.konfigurasi.aksesibilitas.roles.detail.daftar-roles-sub', compact('dataDaftar'));
    }
}
