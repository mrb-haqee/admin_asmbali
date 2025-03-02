<?php

namespace App\Livewire\Konfigurasi\Masterdata\Account;

use App\Models\Account;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\On;
use Livewire\Attributes\Rule;
use Livewire\Component;

class FormAccount extends Component
{

    public $id,  $flag = 'tambah';

    #[Rule('required|string')]
    public $name;

    #[Rule('required|string')]
    public  $kode;

    #[On('submit')]
    public function submit()
    {
        $this->validate();
        try {
            DB::transaction(function () {
                $data = [
                    'name' => $this->name,
                    'kode' => $this->kode,
                    'user_id' => Auth::id(),
                ];

                $account = Account::find($this->id) ?? Account::create($data);

                if ($this->flag === 'update') {
                    unset($data['user_id']);
                    $account->update(array_merge($data, ['user_id_update' => Auth::id()]));
                }

                $this->dispatch('success', "Account Berhasil di " . ($this->flag === 'update' ? "Update" : "Tambah"));
                $this->dispatch('refresh')->to(DaftarAccount::class);
                $this->reset();
            });
        } catch (Exception $e) {
            $this->dispatch('error', "Terjadi kesalahan saat menyimpan data: " . $e->getMessage());
        }
    }

    #[On('delete')]
    public function delete($flag, $id)
    {
        if (!$account = Account::find($id)) {
            $this->dispatch('error', 'Account tidak ditemukan.');
            return;
        }

        if (!app()->runningUnitTests() && $flag === 'confirm') {
            $this->dispatch('swal-confirm', [DaftarAccount::class, 'delete'], ['data' => $id, 'text' => "Data Account \"{$account->name}\" yang dihapus tidak dapat dikembalikan!"]);
            return;
        }

        $account->delete();
        $this->dispatch('success', "Account \"{$account->name}\" berhasil di delete.");
        $this->dispatch('refresh')->to(DaftarAccount::class);
    }

    #[On('setForm')]
    public function setForm($id): void
    {
        if (!$account = Account::find($id)) {
            $this->reset();
            return;
        };

        $this->flag = 'update';
        $this->id = $account->id;
        $this->name = $account->name;
        $this->kode = $account->kode;
    }

    public function render()
    {
        return view('livewire.konfigurasi.masterdata.account.form-account');
    }

    public function updated(): void
    {
        $this->resetErrorBag();
        $this->resetValidation();
    }
}
