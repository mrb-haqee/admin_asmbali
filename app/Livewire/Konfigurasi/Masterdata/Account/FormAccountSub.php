<?php

namespace App\Livewire\Konfigurasi\Masterdata\Account;

use App\Models\Account;
use App\Models\AccountSub;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\On;
use Livewire\Attributes\Rule;
use Livewire\Component;
use SebastianBergmann\Type\NullType;

class FormAccountSub extends Component
{
    public $id, $flag = 'tambah';

    #[Rule('required|string')]
    public $name;

    #[Rule('required|string')]
    public  $kode;
    public  $keterangan;
    public $account;

    #[On('submit')]
    public function submit()
    {
        $this->validate();

        try {
            DB::transaction(function () {

                $data = [
                    'name' => $this->name,
                    'kode' => $this->kode,
                    'keterangan' => $this->keterangan,
                    'account_id' => $this->account?->id,
                    'user_id' => Auth::id()
                ];

                $accountSub = AccountSub::find($this->id) ?? AccountSub::create($data);

                if ($this->flag === 'update') {
                    unset($data['user_id']);
                    unset($data['account_id']);
                    $accountSub->update(array_merge($data, ['user_id_update' => Auth::id()]));
                }

                $this->dispatch('success', "Account Sub Berhasil di " . ($this->flag === 'update' ? "Update" : "Tambah"));
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
        if (!$accountSub = AccountSub::find($id)) {
            $this->dispatch('error', 'Account Sub tidak ditemukan.');
            return;
        }

        if ($flag === 'confirm') {
            $this->dispatch('swal-confirm', [FormAccountSub::class, 'delete'], ['data' => $id]);
            return;
        }

        $accountSub->delete();
        $this->dispatch('success', "Account \"{$accountSub->name}\" berhasil di delete.");
        $this->dispatch('refresh')->to(DaftarAccount::class);
    }

    #[On('setForm')]
    public function setForm($id, ?Account $account = null)
    {
        if (!$accountSub = AccountSub::find($id)) {
            $this->resetExcept();
            $this->account = $account;
            return;
        }

        $this->flag = 'update';
        $this->id = $accountSub->id;
        $this->kode = $accountSub->kode;
        $this->name = $accountSub->name;
        $this->keterangan = $accountSub->keterangan;
    }

    public function render()
    {
        return view('livewire.konfigurasi.masterdata.account.form-account-sub');
    }
    public function updated(): void
    {
        $this->resetErrorBag();
        $this->resetValidation();
    }
}
