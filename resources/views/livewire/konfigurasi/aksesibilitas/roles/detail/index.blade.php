<x-default-layout>

    @section('title')
        Roles
    @endsection

    @section('breadcrumbs')
        {{ Breadcrumbs::render('konfigurasi.aksesibilitas.roles.show', $role) }}
    @endsection

    <!--begin::Content container-->
    <div id="kt_app_content_container" class="app-container container-xxl">
        <!--begin::Layout-->
        <div class="d-flex flex-column flex-lg-row">
            <!--begin::Sidebar-->
            <div class="flex-column flex-lg-row-auto w-100 w-lg-200px w-xl-300px mb-10">
                <!--begin::Card-->
                <div class="card card-flush">
                    <!--begin::Card header-->
                    <div class="card-header">
                        <!--begin::Card title-->
                        <div class="card-title">
                            <h2 class="mb-0">{{ ucwords($role->name) }}</h2>
                        </div>
                        <!--end::Card title-->
                    </div>
                    <!--end::Card header-->
                    <!--begin::Card body-->
                    <div class="card-body pt-0">
                        <!--begin::Permissions-->
                        <div class="d-flex flex-column text-gray-600">
                            @foreach ($role->permissions->shuffle()->take(5) as $permission)
                                <div class="d-flex align-items-center py-2">
                                    <span class="bullet bg-primary me-3"></span>
                                    {{ ucfirst($permission->name) }}
                                </div>
                            @endforeach
                            @if ($role->permissions->count() > 5)
                                <div class="d-flex align-items-center py-2">
                                    <span class='bullet bg-primary me-3'></span>
                                    <em>and {{ $role->permissions->count() - 5 }} more...</em>
                                </div>
                            @endif
                            @if ($role->permissions->count() === 0)
                                <div class="d-flex align-items-center py-2">
                                    <span class='bullet bg-primary me-3'></span>
                                    <em>No permissions given...</em>
                                </div>
                            @endif
                        </div>
                        <!--end::Permissions-->
                    </div>
                    <!--end::Card body-->
                    <!--begin::Card footer-->
                    <div class="card-footer pt-0">
                        <button type="button" class="btn btn-light btn-active-primary"
                            data-role-name="{{ $role->name }}" data-bs-toggle="modal" data-bs-target="#modal_role"
                            data-kt-action="update_row">Edit Role</button>
                    </div>
                    <!--end::Card footer-->
                </div>
                <!--end::Card-->
            </div>
            <!--end::Sidebar-->
            <!--begin::Content-->
            <div class="flex-lg-row-fluid ms-lg-10">
                <!--begin::Card-->
                <div class="card card-flush mb-6 mb-xl-9">
                    <!--begin::Card header-->
                    <div class="card-header pt-5">
                        <!--begin::Card title-->
                        <div class="card-title">
                            <h2 class="d-flex align-items-center">Users Assigned
                                <span class="text-gray-600 fs-6 ms-1">({{ $role->users->count() }})</span>
                            </h2>
                        </div>
                        <!--end::Card title-->
                        <!--begin::Card toolbar-->
                        <div class="card-toolbar">
                            <!--begin::Toolbar-->
                            <div class="d-flex justify-content-end" data-kt-customer-table-toolbar="base">

                                <!--begin::Add customer-->
                                <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal"
                                    data-bs-target="#modal_add_user">
                                    {!! getIcon('plus-square', 'fs-2 ', 'outline', 'i') !!}
                                    User
                                </button>
                                <!--end::Add customer-->
                            </div>
                            <!--end::Toolbar-->

                        </div>
                        <!--end::Card toolbar-->
                    </div>
                    <!--end::Card header-->
                    <!--begin::Card body-->
                    <div class="card-body pt-0">
                        <!--begin::Table-->
                        <div class="table-responsive">
                            @livewire('konfigurasi.aksesibilitas.roles.detail.daftar-roles-sub', compact('role'))
                        </div>
                        <!--end::Table-->
                    </div>
                    <!--end::Card body-->
                </div>
                <!--end::Card-->
            </div>
            <!--end::Content-->
        </div>
        <!--end::Layout-->
    </div>
    <!--end::Content container-->

    <!--begin::Modal-->
    @livewire('konfigurasi.aksesibilitas.roles.form-roles')
    @livewire('konfigurasi.aksesibilitas.roles.detail.form-roles-sub', compact('role'))
    <!--end::Modal-->

    @push('scripts')
        <script data-navigate-once>
            (function() {
                const PageFunction = function() {

                    $('[data-kt-action="update_row"]').on('click', function() {
                        let roleName = $(this).data('role-name');
                        Livewire.dispatch('aksesibilitas.roles.show', [roleName]);
                    });

                    // ============= JANGAN DI UBAH =============
                    KTMenu.createInstances();
                };

                $(document).ready(function() {
                    PageFunction();

                    Livewire.hook("morphed", () => {

                        PageFunction();
                    })

                });
            })();
        </script>
      
    @endpush

</x-default-layout>
