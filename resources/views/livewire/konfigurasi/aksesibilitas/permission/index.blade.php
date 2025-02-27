<x-default-layout>

    @section('title')
        Permissions
    @endsection

    @section('breadcrumbs')
        {{ Breadcrumbs::render('konfigurasi.aksesibilitas.permission.index') }}
    @endsection

    @livewire('konfigurasi.aksesibilitas.permission.data-permission')

</x-default-layout>
