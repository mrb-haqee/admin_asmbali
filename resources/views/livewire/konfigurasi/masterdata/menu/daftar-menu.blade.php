<div class="card" id="menu">
    <!--begin::Card header-->
    <div class="card-header border-0 pt-6">
        <!--begin::Card title-->
        <div class="card-title">

            {{-- <h4 class="card-label fw-bold">{!! getIcon('abstract-45', 'fs-3 me-3', 'outline', 'i') !!}DAFTAR MENU</h4> --}}
            <!--begin::Search-->
            <div class="d-flex align-items-center position-relative my-1">
                {!! getIcon('magnifier', 'fs-3 position-absolute ms-5') !!}
                <input wire:model.live.debounce.300ms="search" type="text"
                    class="form-control form-control-solid w-250px ps-13" placeholder="Search Menu" />
            </div>
            <!--end::Search-->
        </div>
        <!--begin::Card title-->


        <!--begin::Card toolbar-->
        <div class="card-toolbar">
            <!--begin::Toolbar-->
            <div class="d-flex justify-content-end" data-kt-customer-table-toolbar="base">
                {{-- <button type="button" class="btn btn-light-primary me-3" id="button_drawer">
                    <i class="ki-duotone ki-filter fs-2"><span class="path1"></span><span class="path2"></span></i>
                    Filter
                </button>

                <button type="button" class="btn btn-light-primary me-3" data-bs-toggle="modal"
                    data-bs-target="#kt_customers_export_modal">
                    <i class="ki-duotone ki-exit-up fs-2"><span class="path1"></span><span class="path2"></span></i>
                    Export
                </button> --}}

                <!--begin::Add customer-->
                <button wire:click="$dispatch('konfigurasi.masterdata.menu.show', { id: @js(null) })"
                    type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modal_menu">
                    {!! getIcon('plus-square', 'fs-2 ', tag: 'i') !!}
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
                <table id="table_menu" class="table table-row-bordered gy-5 gs-7">
                    <thead>
                        <tr class="text-start fw-bold fs-7 text-uppercase gs-0">
                            <th style="width: 1%;">No</th>
                            <th style="width: 20%;">Group Menu</th>
                            <th style="width: 20%;">Menu</th>
                            <th style="width: 20%;">Aksi</th>
                            <th style="width: 60%;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($dataDaftar as $row)
                            <tr>
                                <td> {{ $loop->iteration }} </td>
                                <td> {{ $row->group }} </td>
                                <td> {{ $row->name }} </td>
                                <td>
                                    @if ($row->option === '__YES__')
                                        <span class="badge badge-light-info">Perent</span>
                                    @else
                                        <span class="badge badge-light-success">Child</span>
                                    @endif
                                </td>
                                <td class="text-nowrap align-middle">
                                    <x-button.dropdown>
                                        <div class="menu-item px-3 ">
                                            <a href="{{ route('konfigurasi.masterdata.menu.show', $row) }}"
                                                class="menu-link px-3">
                                                <i class="fas fa-list me-3"></i> Detail
                                            </a>
                                        </div>
                                        <div class="menu-item px-3 ">
                                            <a wire:click="$dispatch('konfigurasi.masterdata.menu.show', { id: @js($row->id) })"
                                                class="menu-link px-3" data-bs-toggle="modal"
                                                data-bs-target="#modal_menu">
                                                <i class="fas fa-edit me-3"></i> Edit
                                            </a>
                                        </div>
                                        <div class="menu-item px-3">
                                            <a wire:click="$dispatch('konfigurasi.masterdata.menu.delete', { id: @js($row->id), flag: 'confirm' })"
                                                class="menu-link px-3">
                                                <i class="fas fa-trash me-3"></i>Delete
                                            </a>
                                        </div>
                                    </x-button.dropdown>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <!--end::Table-->
    </div>
    <!--end::Card body-->
</div>
