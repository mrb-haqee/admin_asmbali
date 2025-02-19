<div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-125px py-4"
    data-kt-menu="true">
    @if (Str::contains($handle['action'], 'show'))
        <!--begin::Menu item-->
        <div class="menu-item px-3 ">
            <a href="{{ route($handle['routeShow'], ['id' => $data['id']]) }}" class="menu-link px-3" wire:navigate>
                <i class="fas fa-list me-3"></i> Detail
            </a>
        </div>
        <!--end::Menu item-->
    @endif
    @if (Str::contains($handle['action'], 'edit'))
        <!--begin::Menu item-->
        <div class="menu-item px-3 ">
            <a href="#" class="menu-link px-3" data-data-id="{{ $data['id'] }}" data-bs-toggle="modal"
                data-bs-target="#{{ $handle['idModal'] }}" data-kt-action="update_row">
                <i class="fas fa-edit me-3"></i> Edit
            </a>
        </div>
        <!--end::Menu item-->
    @endif
    @if (Str::contains($handle['action'], 'delete'))
        <!--begin::Menu item-->
        <div class="menu-item px-3">
            <a href="#" class="menu-link px-3" data-data-id="{{ $data['id'] }}" data-kt-action="delete_row">
                <i class="fas fa-trash me-3"></i>Delete
            </a>
        </div>
        <!--end::Menu item-->
    @endif
</div>
