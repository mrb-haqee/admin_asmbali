<div>
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

                            @foreach ($dataDaftar as $row)
                                <tr>
                                    <td class="text-center">{{ $loop->iteration }}</td>
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
                                                    data-bs-toggle="modal" data-bs-target="#modal_menu_sub">
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
                                    <td> {{ $menu->name }} </td>
                                    <td> {{ $row->name }} </td>
                                    <td>
                                        @php
                                            $ps = json_decode($row->permissions, true);
                                            $colors = [
                                                'secondary',
                                                'primary',
                                                'info',
                                                'danger',
                                                'success',
                                                'warning',
                                                'dark',
                                            ];
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
            <!--end::Table-->
        </div>
        <!--end::Card body-->
    </div>

    <x-modal.form id="menu_sub" flag="{{ $flag }}">
        <div class="fv-row mb-7">
            <label class="required fw-semibold fs-6 mb-2">Name</label>
            <input type="text" wire:model.defer="name" name="name"
                class="form-control form-control-solid mb-3 mb-lg-0" placeholder="Full name" />
            @error('name')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>

        <div class="mb-7">
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
