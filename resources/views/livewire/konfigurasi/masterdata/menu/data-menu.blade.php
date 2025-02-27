<div>
    <div class="card" id="menu">
        <div class="card-header border-0 pt-6">
            <div class="card-title">
                <div class="d-flex align-items-center position-relative my-1">
                    {!! getIcon('magnifier', 'fs-3 position-absolute ms-5') !!}
                    <input wire:model.live.debounce.300ms="search" type="text"
                        class="form-control form-control-solid w-250px ps-13" placeholder="Search Menu" />
                </div>
            </div>


            <div class="card-toolbar">
                <div class="d-flex justify-content-end" data-kt-customer-table-toolbar="base">
                    <button wire:click="setFrom(null)" type="button" class="btn btn-primary" data-bs-toggle="modal"
                        data-bs-target="#modal_menu">
                        {!! getIcon('plus-square', 'fs-2 ', tag: 'i') !!}
                        Menu
                    </button>
                </div>

            </div>
        </div>

        <div class="card-body py-4">
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
                            @if ($dataDaftar->isEmpty())
                                <x-table.data-not-found :colspan="5" />
                            @else
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
                                                @if ($row->option === '__YES__')
                                                    <div class="menu-item px-3 ">
                                                        <a wire:navigate
                                                            href="{{ route('konfigurasi.masterdata.menu.show', $row) }}"
                                                            class="menu-link px-3">
                                                            <i class="fas fa-list me-3"></i> Detail
                                                        </a>
                                                    </div>
                                                @endif
                                                <div class="menu-item px-3 ">
                                                    <a wire:click="setFrom({{ $row->id }})" class="menu-link px-3"
                                                        data-bs-toggle="modal" data-bs-target="#modal_menu">
                                                        <i class="fas fa-edit me-3"></i> Edit
                                                    </a>
                                                </div>
                                                <div class="menu-item px-3">
                                                    <a wire:click="delete({{ $row->id }}, 'confirm')"
                                                        class="menu-link px-3">
                                                        <i class="fas fa-trash me-3"></i>Delete
                                                    </a>
                                                </div>
                                            </x-button.dropdown>
                                        </td>
                                    </tr>
                                @endforeach
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <x-modal.form id="menu" flag="{{ $flag }}">
        <div class="fv-row mb-7">
            <label class="required fw-semibold fs-6 mb-2">Group</label>
            <div wire:ignore>
                <select id="group" class="form-select form-control-solid mb-3 mb-lg-0" wire:model.defer="group"
                    data-control="select2" data-placeholder="Select an option" data-allow-clear="true"
                    data-hide-search="true" onchange="@this.set('group', this.value)">
                    <option></option>
                    <option value="konfigurasi">Konfigurasi</option>
                    <option value="administrasi">Administrasi</option>
                    <option value="web_asm">Web ASM</option>
                    <option value="web_tpq">Web TPQ</option>
                </select>
            </div>
            @error('group')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>

        <div class="fv-row mb-7">
            <label class="required fw-semibold fs-6 mb-2">Name</label>
            <input type="text" wire:model.defer="name" name="name"
                class="form-control form-control-solid mb-3 mb-lg-0" placeholder="Full name" />
            @error('name')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>

        <div class="fv-row mb-7">
            <label class=" fw-semibold fs-6 mb-2">Sub Menu</label>
            <div class="form-check form-switch form-check-custom form-check-solid">
                <input class="form-check-input" type="checkbox" id="option" wire:model.live="option"
                    name="option" />
            </div>
        </div>


        <div class="mb-7 @if ($option) d-none @endif">
            <!--begin::Label-->
            <label class="required fw-semibold fs-6 mb-5">Permission</label>
            <!--end::Label-->
            @error('checked_permission')
                <span class="text-danger">{{ $message }}</span>
            @enderror
            <!--begin::Roles-->
            <div class="row">
                @foreach ($permissions as $index => $permission)
                    <div class="col-md-6 mb-2">
                        <!--begin::Input row-->
                        <div class="d-flex fv-row">
                            <!--begin::Radio-->
                            <div class="form-check form-check-custom form-check-solid">
                                <!--begin::Input-->
                                <input class="form-check-input me-3" wire:click="toggleRoles('{{ $permission }}')"
                                    type="checkbox" @if (in_array($permission, $checked_permission)) checked @endif />
                                <!--end::Input-->
                                <!--begin::Label-->
                                <label class="form-check-label">
                                    <div class="fw-bold text-gray-800">
                                        {{ ucwords($permission) }}
                                    </div>
                                </label>
                                <!--end::Label-->
                            </div>
                            <!--end::Radio-->
                        </div>
                        <!--end::Input row-->
                        @if (!$loop->last && $index % 2 == 1)
                        @endif
                    </div>
                @endforeach
            </div>
            <!--end::Roles-->
        </div>
    </x-modal.form>
</div>
