<?php

namespace App\Livewire\Konfigurasi\Masterdata\User;

use App\Models\User;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class DaftarUser extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap', $perPage = 6;

    public $search = '';

    #[On('delete')]
    public function delete($flag, $id)
    {
        if ($id == Auth::id()) {
            $this->dispatch('error', 'Tidak bisa menghapus user yang sedang login.');
            return;
        }

        if ($flag === 'confirm') {
            $this->dispatch('swal-confirm', [DaftarUser::class, 'delete'], ['data' => $id]);
            return;
        }

        User::destroy($id);
        $this->dispatch('swal', 'User berhasil dihapus.');
    }

    #[On('refresh')]
    public function render()
    {
        $dataDaftar = User::paginate($this->perPage);
        $this->dispatch('refresh')->to(FormUser::class);
        $pathForm = lwClassToKebab(FormUser::class);
        return view('livewire.konfigurasi.masterdata.user.daftar-user', compact('dataDaftar', 'pathForm'));
    }
}
