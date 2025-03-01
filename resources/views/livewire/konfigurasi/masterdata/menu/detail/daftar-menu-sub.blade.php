<div class="card">
    <div class="card-header border-0 pt-6">
        <div class="card-title">

            {{-- <h4 class="card-label fw-bold">{!! getIcon('abstract-45', 'fs-3 me-3', 'outline', 'i') !!}DAFTAR MENU</h4> --}}
            <div class="d-flex align-items-center position-relative my-1">
                {!! getIcon('magnifier', 'fs-3 position-absolute ms-5') !!}
                <input wire:model.live.debounce.300ms="search" type="text"
                    class="form-control form-control-solid w-250px ps-13" placeholder="Search Menu Sub" />
            </div>
        </div>


        <div class="card-toolbar">
            <div class="d-flex justify-content-end" data-kt-customer-table-toolbar="base">

                <button wire:click="$dispatchTo('{{ $pathForm }}','setForm', {id: null})" class="btn btn-primary"
                    data-bs-toggle="modal" data-bs-target="#modal_menu_sub">
                    {!! getIcon('plus-square', 'fs-2 ', 'outline', 'i') !!}
                    Menu Sub
                </button>
            </div>

        </div>
    </div>

    <div class="card-body py-4">
        <div class="table-responsive">
            <table id="table_menu" class="table table-row-bordered gy-5 gs-7">
                <thead>
                    <tr class="fw-bold fs-6 text-gray-800">
                        <th style="width: 5%;" class="text-center">No</th>
                        <th style="width: 10%;">Aksi</th>
                        <th style="width: 20%;">Menu</th>
                        <th style="width: 20%;">Menu Sub</th>
                        <th style="width: 20%;">Permission</th>
                    </tr>
                </thead>
                <tbody>

                    @if ($dataDaftar->isEmpty())
                        <x-table.data-not-found :colspan="5" />
                    @endif

                    @foreach ($dataDaftar as $row)
                        <tr>
                            <td class="text-center align-middle">{{ $loop->iteration }}</td>
                            <td class="text-nowrap align-middle">
                                <x-button.dropdown>
                                    <div class="menu-item px-3 ">
                                        <a wire:click="$dispatchTo('{{ $pathForm }}','setForm', {id: {{ $row->id }}})"
                                            class="menu-link px-3" data-bs-toggle="modal"
                                            data-bs-target="#modal_menu_sub">
                                            <i class="fas fa-edit me-3"></i> Edit
                                        </a>
                                    </div>
                                    <div class="menu-item px-3">
                                        <a wire:click="delete('confirm', {{ $row->id }})" class="menu-link px-3">
                                            <i class="fas fa-trash me-3"></i>Delete
                                        </a>
                                    </div>
                                </x-button.dropdown>
                            </td>
                            <td class=" align-middle"> {{ $menu->name }} </td>
                            <td class=" align-middle"> {{ $row->name }} </td>
                            <td class=" align-middle">
                                @php
                                    $ps = json_decode($row->permissions, true);
                                    $colors = ['secondary', 'primary', 'info', 'danger', 'success', 'warning', 'dark'];
                                @endphp

                                <div class="d-sm-flex flex-wrap gap-2 d-none">
                                    @foreach ($ps as $index => $p)
                                        <span class="badge badge-{{ $colors[$index % count($colors)] }}">
                                            {{ ucwords($p) }}
                                        </span>
                                    @endforeach
                                </div>

                                <div class="d-flex flex-wrap gap-2 d-sm-none">
                                    @foreach ($ps as $index => $p)
                                        <span class="badge badge-{{ $colors[$index % count($colors)] }}">
                                            {{ ucwords($p) }}
                                        </span>
                                        @if ($loop->iteration == 2)
                                            <span class="badge badge-secondary">More...</span>
                                            @break
                                        @endif
                                    @endforeach
                                </div>
                            </td>
                        </tr>
                    @endforeach

                </tbody>
            </table>
        </div>
    </div>
</div>
