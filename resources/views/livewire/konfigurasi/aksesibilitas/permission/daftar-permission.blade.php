<div class="card">
    <!--begin::Card header-->
    <div class="card-header border-0 pt-6">
        <!--begin::Card title-->
        <div class="card-title">
            <!--begin::Search-->
            <div class="d-flex align-items-center position-relative my-1">
                {!! getIcon('magnifier', 'fs-3 position-absolute ms-5') !!}
                <input type="text" data-kt-user-table-filter="search"
                    class="form-control form-control-solid w-250px ps-13" placeholder="Search permission"
                    id="mySearchInput" />
            </div>
            <!--end::Search-->
        </div>
        <!--begin::Card title-->
        <!--begin::Card toolbar-->
        <div class="card-toolbar">

            @if (empty($checked_permissions))
                <!--begin::Toolbar-->
                <div class="d-flex justify-content-end">
                    <button
                        wire:click="$dispatch('aksesibilitas.permission.from', { id: @js(null) })"
                        type="button" class="btn btn-light-primary" data-bs-toggle="modal"
                        data-bs-target="#kt_modal_update_permission">
                        {!! getIcon('plus-square', 'fs-3', tag: 'i') !!}
                        Add
                    </button>
                </div>
                <!--end::Toolbar-->
            @else
                <!--begin::Group actions-->
                <div class="d-flex justify-content-end align-items-center">
                    <div class="fw-bold me-5">
                        <span class="me-2" data-kt-user-table-select="selected_count"></span>
                        Selected
                    </div>

                    <button type="button" class="btn btn-danger" wire:click="deleteRoleChecked('confirm')">
                        {!! getIcon('trash', 'fs-3', tag: 'i') !!}
                        Delete Selected
                    </button>
                </div>
                <!--end::Group actions-->
            @endif

        </div>
        <!--end::Card toolbar-->

    </div>
    <!--end::Card header-->

    <!--begin::Card body-->
    <div class="card-body py-4">
        <!--begin::Table-->
        <div class="table-responsive">
            <table id="table_menu" class="table table-row-bordered gy-5 gs-7">
                <thead class="">
                    <tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0">
                        <th style="width: 1%;" class="d-none d-sm-table-cell"></th>
                        <th style="width: 20%;">Name</th>
                        <th style="width: 10%;">assigned to</th>
                        <th style="width: 20%;">created at</th>
                        <th style="width: 10%;">actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($dataDaftar as $row)
                        <tr class="fw-bold fs-7" wire:key="{{ $row->id }}">
                            <td class="align-middle d-none d-sm-table-cell ">
                                <label class="form-check form-check-sm form-check-custom form-check-solid me-9">
                                    <input class="form-check-input" type="checkbox"
                                        wire:change="toggleChecked({{ $row->id }})" wire:loading.attr="disabled" />
                                </label>
                            </td>
                            <td class="text-muted fw-bold fs-5 align-middle"> {{ $row->name }} </td>
                            <td class="align-middle">
                                @foreach ($row->roles as $role)
                                    <a href="{{ route('konfigurasi.aksesibilitas.roles.show', $role) }}"
                                        class="badge fs-7 m-1 {{ app(\App\Actions\GetThemeType::class)->handle('badge-light-?', $role->name) }}">
                                        {{ $role->name }}
                                    </a>
                                @endforeach
                            </td>
                            <td class="text-nowrap text-muted align-middle">
                                {{ $row->created_at->format('d M Y, h:i a') }}
                            </td>
                            <td class="text-nowrap align-middle">
                                <button
                                    wire:click="$dispatch('aksesibilitas.permission.from', { id: @js($row->id) })"
                                    class="btn btn-icon btn-active-light-primary w-30px h-30px me-3"
                                    data-permission-id="{{ $row->name }}" data-bs-toggle="modal"
                                    data-bs-target="#kt_modal_update_permission">
                                    {!! getIcon('setting-3', 'fs-3') !!}
                                </button>
                                <button
                                    wire:click="$dispatch('aksesibilitas.permission.delete', { id: @js($row->id), flag: 'confirm' })"
                                    class="btn btn-icon btn-active-light-primary w-30px h-30px"
                                    data-permission-id="{{ $row->name }}" data-kt-action="delete_row">
                                    {!! getIcon('trash', 'fs-3') !!}
                                </button>

                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <!--end::Table-->
    </div>
    <!--end::Card body-->
</div>

@push('scripts')
    <script data-navigate-once></script>
@endpush
