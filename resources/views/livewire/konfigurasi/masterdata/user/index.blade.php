<x-default-layout>

    @section('title')
        User
    @endsection

    @section('breadcrumbs')
        {{ Breadcrumbs::render('konfigurasi.masterdata.user.index') }}
    @endsection

    @livewire('konfigurasi.masterdata.user.daftar-user')
    @livewire('konfigurasi.masterdata.user.form-user')

</x-default-layout>
