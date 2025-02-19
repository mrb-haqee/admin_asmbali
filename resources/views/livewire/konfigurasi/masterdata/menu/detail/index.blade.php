<x-default-layout>

    @section('title')
        Menu Sub
    @endsection

    @section('breadcrumbs')
        {{ Breadcrumbs::render('konfigurasi.masterdata.menu.show', $menu) }}
    @endsection

    <!--begin::Layout-->
    <div class="d-flex flex-column flex-lg-row">
        <!--begin::Sidebar-->
        <div class="flex-column flex-lg-row-auto w-lg-250px w-xl-350px mb-10">
            <!--begin::Card-->
            <div class="card mb-5 mb-xl-8">
                <!--begin::Card body-->
                <div class="card-body">

                    <!--begin::Details content-->
                    <div class="pb-5 fs-6">
                        <!--begin::Details item-->
                        <div class="fw-bold mt-5">Menu</div>
                        <div class="text-gray-600">{{ $menu->name }}</div>
                        <!--begin::Details item-->
                        <!--begin::Details item-->
                        <div class="fw-bold mt-5">Group</div>
                        <div class="text-gray-600">{{ $menu->group }}</div>
                        <!--begin::Details item-->
                        <!--begin::Details item-->
                        <div class="fw-bold mt-5">Id</div>
                        <div class="text-gray-600">{{ $menu->id }}</div>
                        <!--begin::Details item-->

                    </div>
                    <!--end::Details content-->
                </div>
                <!--end::Card body-->
            </div>
            <!--end::Card-->
        </div>
        <!--end::Sidebar-->
        <!--begin::Content-->
        <div class="flex-lg-row-fluid ms-lg-15">
            <div class="card" id="menu">
                <!--begin::Card header-->
                <div class="card-header border-0 pt-6">
                    <!--begin::Card title-->
                    <div class="card-title">

                        {{-- <h4 class="card-label fw-bold">{!! getIcon('abstract-45', 'fs-3 me-3', 'outline', 'i') !!}DAFTAR MENU</h4> --}}
                        <!--begin::Search-->
                        <div class="d-flex align-items-center position-relative my-1">
                            {!! getIcon('magnifier', 'fs-3 position-absolute ms-5') !!}
                            <input type="text" data-filter="search"
                                class="form-control form-control-solid w-250px ps-13" placeholder="Search Menu Sub" />
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
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                data-bs-target="#modal_menu_sub">
                                {!! getIcon('plus-square', 'fs-2 ', 'outline', 'i') !!}
                                Menu Sub
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
                            @livewire('konfigurasi.masterdata.menu.detail.daftar-menu-sub', ['menu' => $menu])
                        </div>
                    </div>
                    <!--end::Table-->
                </div>
                <!--end::Card body-->
            </div>
        </div>
        <!--end::Content-->
    </div>

    @livewire('konfigurasi.masterdata.menu.detail.form-menu-sub', ['menu' => $menu])
    <x-filter.filter-drawer />
</x-default-layout>
