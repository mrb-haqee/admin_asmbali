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
                    class="form-control form-control-solid w-250px ps-13" placeholder="Search Menu Sub" />
            </div>
            <!--end::Search-->
        </div>
        <!--begin::Card title-->


        <!--begin::Card toolbar-->
        <div class="card-toolbar">
            <!--begin::Toolbar-->
            <div class="d-flex justify-content-end" data-kt-customer-table-toolbar="base">

                <!--begin::Add customer-->
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modal_menu_sub">
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
                <table id="table_menu" class="table table-row-bordered gy-5 gs-7">
                    <thead>
                        <tr class="fw-bold fs-6 text-gray-800">
                            <th style="width: 5%;" class="text-center">No</th>
                            <th style="width: 10%;">Aksi</th>
                            <th style="width: 20%;">Menu</th>
                            <th style="width: 20%;">Menu Sub</th>
                        </tr>
                    </thead>
                    <tbody>

                        @foreach ($dataDaftar as $row)
                            <tr>
                                <td class="text-center">{{ $loop->iteration }}</td>
                                <td>
                                    <x-button.dropdown>
                                        <div class="menu-item px-3 ">
                                            <a wire:click="$dispatch('konfigurasi.masterdata.menu.detail.show', { id: @js($row->id) })"
                                                class="menu-link px-3" data-bs-toggle="modal"
                                                data-bs-target="#modal_menu_sub">
                                                <i class="fas fa-edit me-3"></i> Edit
                                            </a>
                                        </div>
                                        <div class="menu-item px-3">
                                            <a wire:click="$dispatch('konfigurasi.masterdata.menu.detail.delete', { id: @js($row->id), flag: 'confirm' })"
                                                class="menu-link px-3">
                                                <i class="fas fa-trash me-3"></i>Delete
                                            </a>
                                        </div>
                                    </x-button.dropdown>
                                </td>
                                <td> {{ $menu->name }} </td>
                                <td> {{ $row->name }} </td>
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

@push('scripts')
    <script data-navigate-once>
        $(document).ready(function() {
            $("input[data-filter='drawer']").each((i, element) => {
                @this.set($(element).attr('name'), $(element).val());
            })

            $("#menu input[data-filter='search']").on('change', function(e) {
                @this.set('search', e.target.value);
            });

            $("#button-filter").on('click', function(e) {
                @this.set('search', '');
                $("input[data-filter='drawer']").each((i, element) => {
                    @this.set($(element).attr('name'), $(element).val());
                })
            });

            Livewire.on('proses-selesai', function() {
                $('#modal_menu_sub').modal('hide');
                @this.call('getDataDaftar')
            })
        });
    </script>
@endpush
