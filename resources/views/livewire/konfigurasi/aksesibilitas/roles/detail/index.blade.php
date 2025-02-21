<div>
    <x-default-layout>

        @section('title')
            Roles
        @endsection

        @section('breadcrumbs')
            {{ Breadcrumbs::render('konfigurasi.aksesibilitas.roles.show', $role) }}
        @endsection

        <!--begin::Content container-->
        <div id="kt_app_content_container" class="app-container container-xxl">
            @livewire('konfigurasi.aksesibilitas.roles.detail.daftar-roles-sub', compact('role'))
        </div>
        <!--end::Content container-->

        <!--begin::Modal-->
        @livewire('konfigurasi.aksesibilitas.roles.form-roles')
        @livewire('konfigurasi.aksesibilitas.roles.detail.form-roles-sub', compact('role'))
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

</div>
