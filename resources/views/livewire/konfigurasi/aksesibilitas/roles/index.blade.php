<x-default-layout>

    @section('title')
        Roles
    @endsection

    @section('breadcrumbs')
        {{ Breadcrumbs::render('konfigurasi.aksesibilitas.roles.index') }}
    @endsection
    <!--begin::Content container-->
    <div id="kt_app_content_container" class="app-container container-xxl">
        @livewire('konfigurasi.aksesibilitas.roles.data-roles')
    </div>
    <!--end::Content container-->

</x-default-layout>
