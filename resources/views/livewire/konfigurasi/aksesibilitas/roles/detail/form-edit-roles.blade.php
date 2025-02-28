<div class="card card-flush">
    <!--begin::Card header-->
    <div class="card-header">
        <!--begin::Card title-->
        <div class="card-title">
            <h2 class="mb-0">{{ ucwords($role->name) }}</h2>
        </div>
        <!--end::Card title-->
    </div>
    <!--end::Card header-->
    <!--begin::Card body-->
    <div class="card-body pt-0">
        <!--begin::Permissions-->
        <div class="d-flex flex-column text-gray-600">
            @foreach ($role->permissions->take(5) as $permission)
                <div class="d-flex align-items-center py-2">
                    <span class="bullet bg-primary me-3"></span>
                    {{ ucfirst($permission->name) }}
                </div>
            @endforeach
            @if ($role->permissions->count() > 5)
                <div class="d-flex align-items-center py-2">
                    <span class='bullet bg-primary me-3'></span>
                    <em>and {{ $role->permissions->count() - 5 }} more...</em>
                </div>
            @endif
            @if ($role->permissions->count() === 0)
                <div class="d-flex align-items-center py-2">
                    <span class='bullet bg-primary me-3'></span>
                    <em>No permissions given...</em>
                </div>
            @endif
        </div>
        <!--end::Permissions-->
    </div>
    <!--end::Card body-->
    <!--begin::Card footer-->
    <div class="card-footer pt-0">
        <button wire:click="$dispatch('aksesibilitas.roles.from', { id: @js($role->id) })"
            class="btn btn-light btn-active-primary" data-bs-toggle="modal" data-bs-target="#modal_role">
            Edit Role
        </button>
    </div>
    <!--end::Card footer-->
</div>
