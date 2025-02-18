<table id="table_menu" class="table table-row-bordered gy-5 gs-7">
    <thead>
        <tr class="fw-bold fs-6 text-gray-800">
            <th style="width: 5%;" class="text-center">No</th>
            <th style="width: 10%;">Aksi</th>
            <th style="width: 20%;">Group Menu</th>
            <th style="width: 20%;">Menu</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($dataDaftar as $i => $row)
            <tr>
                <td class="text-center">{{ $i + 1 }}</td>
                <td>
                    <a href="#" class="btn btn-light btn-active-light-primary btn-flex btn-center btn-sm"
                        data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
                        Actions
                        <i class="ki-duotone ki-down fs-5 ms-1"></i>
                    </a>
                    <!--begin::Menu-->
                    <x-button.button-action :data="['id' => $row['id']]" :handle="['idModal' => 'modal_menu', 'routeShow' => 'konfigurasi.masterdata.menu.show']" />
                    <!--end::Menu-->
                </td>
                <td> {{ $row['group'] }} </td>
                <td> {{ $row['name'] }} </td>
            </tr>
        @endforeach
    </tbody>
</table>


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
                $('#modal_menu').modal('hide');
                @this.call('getDataDaftar')
            })
        });
    </script>
@endpush

{{-- <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-125px py-4"
                        data-kt-menu="true">
                        <!--begin::Menu item-->
                        <div class="menu-item px-3 ">
                            <a href="{{ route('konfigurasi.masterdata.menu.show', ['id' => $row['id']]) }}"
                                class="menu-link px-3">
                                <i class="fas fa-list me-3"></i> Detail
                            </a>
                        </div>
                        <!--end::Menu item-->
                        <!--begin::Menu item-->
                        <div class="menu-item px-3 ">
                            <a href="#" class="menu-link px-3" data-menu-id="{{ $row['id'] }}"
                                data-bs-toggle="modal" data-bs-target="#modal_menu" data-kt-action="update_row">
                                <i class="fas fa-edit me-3"></i> Edit
                            </a>
                        </div>
                        <!--end::Menu item-->

                        <!--begin::Menu item-->
                        <div class="menu-item px-3">
                            <a href="#" class="menu-link px-3" data-menu-id="{{ $row['id'] }}"
                                data-kt-action="delete_row">
                                <i class="fas fa-trash me-3"></i>Delete
                            </a>
                        </div>
                        <!--end::Menu item-->
                    </div> --}}
