<x-default-layout>

    @section('title')
        Menu
    @endsection

    @section('breadcrumbs')
        {{ Breadcrumbs::render('konfigurasi.masterdata.menu.index') }}
    @endsection


    @livewire('konfigurasi.masterdata.menu.daftar-menu')
    @livewire('konfigurasi.masterdata.menu.form-menu')

</x-default-layout>
