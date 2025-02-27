<x-default-layout :pageDetail=true>

    @section('title')
        Menu Sub
    @endsection

    @section('toolbar-header')
        <a wire:navigate href="{{ route('konfigurasi.masterdata.menu.index') }}"
            class="bg-danger px-4 py-3 fw-bold rounded text-white text-center">
            <i class="fas fa-arrow-alt-circle-left fs-5 text-white me-2 pt-1"></i> <span>Back</span>
        </a>
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
            @livewire('konfigurasi.masterdata.menu.detail.data-menu-sub', compact('menu'))
        </div>
        <!--end::Content-->
    </div>

</x-default-layout>
