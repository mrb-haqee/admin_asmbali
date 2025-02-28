<x-default-layout pageDetail=true>

    @section('title')
        Roles
    @endsection

    @section('breadcrumbs')
        {{ Breadcrumbs::render('konfigurasi.aksesibilitas.roles.show', $role) }}
    @endsection

    <!--begin::Content container-->
    <div id="kt_app_content_container" class="app-container container-fluid ">
        <!--begin::Layout-->
        <div class="d-flex flex-column flex-lg-row">
            <!--begin::Sidebar-->
            <div class="flex-column flex-lg-row-auto w-100 w-lg-200px w-xl-300px mb-10">
                @livewire('konfigurasi.aksesibilitas.roles.detail.form-edit-roles', compact('role'))
            </div>
            <!--end::Sidebar-->

            <!--begin::Content-->
            <div class="flex-lg-row-fluid ms-lg-10">
                @livewire('konfigurasi.aksesibilitas.roles.detail.daftar-roles-sub', compact('role'))
            </div>
            <!--end::Content-->
        </div>
        <!--end::Layout-->

    </div>
    <!--end::Content container-->
    
    <!--begin::Modal-->
    @livewire('konfigurasi.aksesibilitas.roles.detail.form-add-user-roles', compact('role'))
    <!--end::Modal-->

</x-default-layout>
