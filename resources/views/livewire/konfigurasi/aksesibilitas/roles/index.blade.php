<x-default-layout>

    @section('title')
        Roles
    @endsection

    @section('breadcrumbs')
        {{ Breadcrumbs::render('konfigurasi.aksesibilitas.roles.index') }}
    @endsection
    <!--begin::Content container-->
    <div id="kt_app_content_container" class="app-container container-xxl">
        @livewire('konfigurasi.aksesibilitas.roles.daftar-roles')
    </div>
    <!--end::Content container-->

    <!--begin::Modal-->
    @livewire('konfigurasi.aksesibilitas.roles.form-roles')
    <!--end::Modal-->

    @push('scripts')
        <script data-navigate-once>
            $(document).ready(function() {
                Livewire.on('success', function() {
                    $('.modal').modal('hide');
                });
            });
        </script>
    @endpush

</x-default-layout>
