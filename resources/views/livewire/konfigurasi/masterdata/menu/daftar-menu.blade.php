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
                    <x-button.button-action :data="['id' => $row['id']]" :handle="[
                        'action' => $row['option'] === '__YES__' ? 'show,edit,delete' : 'edit,delete',
                        'idModal' => 'modal_menu',
                        'routeShow' => 'konfigurasi.masterdata.menu.show',
                    ]" />
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
