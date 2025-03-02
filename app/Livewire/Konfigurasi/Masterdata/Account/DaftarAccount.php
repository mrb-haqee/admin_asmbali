<?php

namespace App\Livewire\Konfigurasi\Masterdata\Account;

use App\Models\Account;
use Livewire\Attributes\On;
use Livewire\Component;

class DaftarAccount extends Component
{
    public $search = '';

    #[On('refresh')]
    public function render()
    {
        $dataDaftar = Account::with('accountSub')->get();

        $pathForm = lwClassToKebab(FormAccount::class);
        $pathFormSub = lwClassToKebab(FormAccountSub::class);
        return view('livewire.konfigurasi.masterdata.account.daftar-account', compact('dataDaftar', 'pathForm', 'pathFormSub'));
    }
}
