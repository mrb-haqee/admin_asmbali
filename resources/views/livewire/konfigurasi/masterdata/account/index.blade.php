<x-default-layout>

    @section('title')
        Account
    @endsection

    @section('breadcrumbs')
        {{-- {{ Breadcrumbs::render('') }} --}}
    @endsection

    @livewire('konfigurasi.masterdata.account.daftar-account')

    @section('modals')
        @livewire('konfigurasi.masterdata.account.form-account')
        @livewire('konfigurasi.masterdata.account.form-account-sub')
    @endsection

</x-default-layout>
