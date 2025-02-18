<x-default-layout>

    @section('title')
        Menu
    @endsection

    @section('breadcrumbs')
        {{ Breadcrumbs::render('user-management.permissions.index') }}
    @endsection

    <div class="card" id="menu">
        <!--begin::Card header-->
        <div class="card-header border-0 pt-6">
            <!--begin::Card title-->
            <div class="card-title">

                {{-- <h4 class="card-label fw-bold">{!! getIcon('abstract-45', 'fs-3 me-3', 'outline', 'i') !!}DAFTAR MENU</h4> --}}
                <!--begin::Search-->
                <div class="d-flex align-items-center position-relative my-1">
                    {!! getIcon('magnifier', 'fs-3 position-absolute ms-5') !!}
                    <input type="text" data-filter="search" class="form-control form-control-solid w-250px ps-13"
                        placeholder="Search Menu" />
                </div>
                <!--end::Search-->
            </div>
            <!--begin::Card title-->


            <!--begin::Card toolbar-->
            <div class="card-toolbar">
                <!--begin::Toolbar-->
                <div class="d-flex justify-content-end" data-kt-customer-table-toolbar="base">
                    <!--begin::Filter-->
                    <button type="button" class="btn btn-light-primary me-3" id="button_drawer">
                        <i class="ki-duotone ki-filter fs-2"><span class="path1"></span><span
                                class="path2"></span></i> Filter
                    </button>
                    <!--end::Filter-->

                    {{-- <!--begin::Export-->
                    <button type="button" class="btn btn-light-primary me-3" data-bs-toggle="modal"
                        data-bs-target="#kt_customers_export_modal">
                        <i class="ki-duotone ki-exit-up fs-2"><span class="path1"></span><span
                                class="path2"></span></i> Export
                    </button>
                    <!--end::Export--> --}}

                    <!--begin::Add customer-->
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modal_menu">
                        {!! getIcon('plus-square', 'fs-2 ', 'outline', 'i') !!}
                        Menu
                    </button>
                    <!--end::Add customer-->
                </div>
                <!--end::Toolbar-->

            </div>
            <!--end::Card toolbar-->
        </div>
        <!--end::Card header-->

        <!--begin::Card body-->
        <div class="card-body py-4">
            <!--begin::Table-->
            <div class="table-responsive">
                <div class="table-responsive">
                    @livewire('konfigurasi.masterdata.menu.daftar-menu')
                </div>
            </div>
            <!--end::Table-->
        </div>
        <!--end::Card body-->
    </div>

    <x-filter.filter-drawer />
    @livewire('konfigurasi.masterdata.menu.form-menu')

    {{-- @livewire('utiliti.filter.filter-drawer') --}}
</x-default-layout>
