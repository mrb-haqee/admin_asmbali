<div class="card">
    <div class="card-header border-0 pt-6">
        <div class="card-title">
            <div class="d-flex align-items-center position-relative my-1">
                {!! getIcon('magnifier', 'fs-3 position-absolute ms-5') !!}
                <input wire:model.live.debounce.300ms="search" type="text"
                    class="form-control form-control-solid w-250px ps-13" placeholder="Search Account" />
            </div>
        </div>


        <div class="card-toolbar">
            <div class="d-flex justify-content-end" data-kt-customer-table-toolbar="base">
                <button wire:click="$dispatchTo('{{ $pathForm }}','setForm', {id: null})" class="btn btn-primary"
                    data-bs-toggle="modal" data-bs-target="#modal_account">
                    {!! getIcon('plus-square', 'fs-2 ', tag: 'i') !!}
                    Account
                </button>
            </div>

        </div>
    </div>

    <div class="card-body py-4">
        <div class="table-responsive">
            <table id="table_menu" class="table table-row-bordered gy-5 gs-7">
                <thead>
                    <tr class="text-start fw-bold fs-7 text-uppercase gs-0">
                        <th class="text-center" style="width: 10%;">No</th>
                        <th style="width: 20%;">Aksi</th>
                        <th style="width: 20%;">Kode</th>
                        <th style="width: 20%;">Nama</th>
                        <th class="d-none d-sm-table-cell" style="width: 60%;">Keterangan</th>
                    </tr>
                </thead>
                <tbody>
                    @if ($dataDaftar->isEmpty())
                        <x-table.data-not-found :colspan="5" />
                    @else
                        @foreach ($dataDaftar as $row)
                            <tr wire:key="{{ $row->id }}">
                                <td class="text-center align-middle" class="d-flex"> {{ $loop->iteration }}
                                    <button class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm ms-2"
                                        onclick="$('.row_{{ $row->id }}').toggleClass('d-none')">
                                        <i class="fas fa-list"></i>
                                    </button>
                                </td>

                                <td>
                                    <x-button.dropdown>
                                        <div class="menu-item px-3 ">
                                            <a wire:click="$dispatchTo('{{ $pathForm }}','setForm', {id: {{ $row->id }}})"
                                                class="menu-link px-3 fw-bold bg-light bg-hover-info text-hover-white"
                                                data-bs-toggle="modal" data-bs-target="#modal_account">
                                                <i class="fas fa-edit me-3"></i> EDIT
                                            </a>
                                        </div>
                                        <div class="menu-item px-3 ">
                                            <a wire:click="$dispatchTo('{{ $pathForm . '-sub' }}','setForm', {id: null, account: {{ $row->id }} })"
                                                class="menu-link px-3 fw-bold bg-light bg-hover-success text-hover-white"
                                                data-bs-toggle="modal" data-bs-target="#modal_account_sub">
                                                <i class="fa-solid fa-square-plus me-3"></i> SUB
                                            </a>
                                        </div>
                                        <div class="menu-item px-3">
                                            <a onclick="swalConfirm(['{{ $pathForm }}', 'delete'], {data: '{{ $row->id }}', text:'Data Account \'{{ $row->name }}\' yang dihapus tidak dapat dikembalikan!'})"
                                                class="menu-link px-3 fw-bold bg-light bg-hover-danger text-hover-white">
                                                <i class="fas fa-trash me-3"></i>Delete
                                            </a>

                                        </div>
                                    </x-button.dropdown>
                                </td>
                                <td> {{ $row->kode }} </td>
                                <td> {{ $row->name }} </td>
                                <td class="d-none d-sm-table-cell"> </td>
                            </tr>
                            @foreach ($row->accountSub as $rowSub)
                                <tr wire:key="{{ $rowSub->id }}_sub"
                                    class="d-none row_detail row_{{ $row->id }} table-light">
                                    <td class="text-center align-middle"> {{ $loop->iteration }} </td>

                                    <td>
                                        <x-button.dropdown>
                                            <div class="menu-item px-3 ">
                                                <a wire:click="$dispatchTo('{{ $pathForm . '-sub' }}','setForm', {id: {{ $rowSub->id }} })"
                                                    class="menu-link px-3" data-bs-toggle="modal"
                                                    data-bs-target="#modal_account_sub">
                                                    <i class="fas fa-edit me-3"></i> Edit
                                                </a>
                                            </div>
                                            <div class="menu-item px-3">
                                                <a onclick="swalConfirm(['{{ $pathForm . '-sub' }}', 'delete'], {data: '{{ $rowSub->id }}', text:'Data Account Sub \'{{ $rowSub->name }}\' yang dihapus tidak dapat dikembalikan!'})"
                                                    class="menu-link px-3">
                                                    <i class="fas fa-trash me-3"></i>Delete
                                                </a>
                                            </div>
                                        </x-button.dropdown>
                                    </td>
                                    <td> {{ $rowSub->kode }} </td>
                                    <td> {{ $rowSub->name }} </td>
                                    <td class="d-none d-sm-table-cell"> {{ $rowSub->keterangan }} </td>
                                </tr>
                            @endforeach
                        @endforeach
                    @endif
                </tbody>
            </table>
        </div>
    </div>

</div>
