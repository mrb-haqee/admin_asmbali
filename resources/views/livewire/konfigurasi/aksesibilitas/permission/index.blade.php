<x-default-layout>

    @section('title')
        Permissions
    @endsection

    @section('breadcrumbs')
        {{ Breadcrumbs::render('konfigurasi.aksesibilitas.permission.index') }}
    @endsection

    @livewire('konfigurasi.aksesibilitas.permission.daftar-permission')
    @livewire('konfigurasi.aksesibilitas.permission.form-permission')

    @push('scripts')
        <script></script>
    @endpush

</x-default-layout>
