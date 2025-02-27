<div>
    <div class="row row-cols-1 row-cols-md-2 row-cols-xl-3 g-5 g-xl-9">
        @foreach ($roles as $role)
            <!--begin::Col-->
            <div class="col-md-4">
                <!--begin::Card-->
                <div class="card card-flush h-md-100">
                    <!--begin::Card header-->
                    <div class="card-header">
                        <!--begin::Card title-->
                        <div class="card-title d-flex justify-content-between">
                            <h2>
                                <a href="{{ route('konfigurasi.aksesibilitas.roles.show', $role) }}">
                                    {{ ucwords($role->name) }}
                                </a>
                            </h2>
                        </div>
                        <div class="card-toolbar">
                            <a wire:click="delete({{ $role->id }}, 'confirm')" href="#"
                                class="btn btn-icon btn-sm btn-active-color-primary delete-role" data-bs-toggle="tooltip"
                                title="Delete Role" data-bs-trigger="hover">
                                {!! getIcon('cross', 'fs-1 text-danger bg-light') !!}
                            </a>
                        </div>
                    </div>
                    <!--end::Card header-->
                    <!--begin::Card body-->
                    <div class="card-body pt-1">
                        <!--begin::Users-->
                        <div class="fw-bold text-gray-600 mb-5">Total users with this role: {{ $role->users->count() }}
                        </div>
                        <!--end::Users-->
                        <!--begin::Permissions-->
                        <div class="d-flex flex-column text-gray-600">
                            @foreach ($role->permissions->shuffle()->take(5) ?? [] as $permission)
                                <div class="d-flex align-items-center py-2">
                                    <span class="bullet bg-primary me-3"></span>{{ ucfirst($permission->name) }}
                                </div>
                            @endforeach
                            @if ($role->permissions->count() > 5)
                                <div class='d-flex align-items-center py-2'>
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
                    <div class="card-footer flex-wrap pt-0">
                        <a href="{{ route('konfigurasi.aksesibilitas.roles.show', $role) }}"
                            class="btn btn-light btn-active-primary my-1 me-2">View Role</a>

                        <button wire:click="setForm({{ $role->id }})"
                            class="btn btn-light btn-active-light-primary my-1" data-bs-toggle="modal"
                            data-bs-target="#modal_roles">
                            Edit Role
                        </button>
                    </div>
                    <!--end::Card footer-->
                </div>
                <!--end::Card-->
            </div>
            <!--end::Col-->
        @endforeach

        <!--begin::Add new card-->
        <div class="ol-md-4">
            <!--begin::Card-->
            <div class="card h-md-100">
                <!--begin::Card body-->
                <div class="card-body d-flex flex-center">
                    <!--begin::Button-->
                    <button wire:click="setForm(null)"
                        class="btn btn-clear d-flex flex-column flex-center" data-bs-toggle="modal"
                        data-bs-target="#modal_roles">
                        <!--begin::Illustration-->
                        <img src="{{ image('illustrations/sketchy-1/4.png') }}" alt=""
                            class="mw-100 mh-150px mb-7" />
                        <!--end::Illustration-->
                        <!--begin::Label-->
                        <div class="fw-bold fs-3 text-gray-600 text-hover-primary">Add New Role</div>
                        <!--end::Label-->
                    </button>
                    <!--begin::Button-->
                </div>
                <!--begin::Card body-->
            </div>
            <!--begin::Card-->
        </div>
        <!--begin::Add new card-->
    </div>

    <x-modal.form id="roles" flag="{{ $flag }}" sizeModal="modal-xl">
        <!--begin::Input group-->
        <div class="fv-row mb-10">
            <!--begin::Label-->
            <label class="fs-5 fw-bold form-label mb-2">
                <span class="required">Role name</span>
            </label>
            <!--end::Label-->
            <!--begin::Input-->
            <input class="form-control form-control-solid" placeholder="Enter a role name" name="name"
                wire:model="name" />
            <!--end::Input-->
            @error('name')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
        <!--end::Input group-->

        <!--begin::Permissions-->
        <div class="fv-row">
            <!--begin::Label-->
            <label class="fs-5 fw-bold form-label mb-2">Role Permissions</label>
            <!--end::Label-->
            <!--begin::Table wrapper-->
            <div class="table-responsive">
                <!--begin::Table-->
                <table class="table align-middle table-row-dashed fs-6 gy-5">
                    <!--begin::Table body-->
                    <tbody class="text-gray-600 fw-semibold">
                        <!--begin::Table row-->
                        <tr>
                            <td class="text-gray-800">Administrator Access
                                <span class="ms-1" data-bs-toggle="tooltip"
                                    title="Allows a full access to the system">
                                    {!! getIcon('information-5', 'text-gray-500 fs-6') !!}
                                </span>
                            </td>
                            <td>
                                <!--begin::Checkbox-->
                                <label class="form-check form-check-sm form-check-custom form-check-solid me-9">
                                    <input class="form-check-input" type="checkbox" id="kt_roles_select_all"
                                        wire:model="check_all" wire:change="checkAll" />
                                    <span class="form-check-label" for="kt_roles_select_all">Select
                                        all</span>
                                </label>
                                <!--end::Checkbox-->
                            </td>
                        </tr>
                        <!--end::Table row-->
                        @foreach ($permissions_by_group as $group => $permissions)
                            <!--begin::Table row-->
                            <tr>
                                <!--begin::Label-->
                                <td class="text-gray-800">{{ ucwords($group) }}</td>
                                <!--end::Label-->
                                <!--begin::Input group-->
                                @foreach ($permissions as $permission)
                                    <td>
                                        <!--begin::Wrapper-->
                                        <div class="d-flex">
                                            <!--begin::Checkbox-->
                                            <label
                                                class="form-check form-check-sm form-check-custom form-check-solid me-5 me-lg-20">
                                                <input class="form-check-input" type="checkbox"
                                                    wire:model="checked_permissions" value="{{ $permission->name }}" />
                                                <span
                                                    class="form-check-label">{{ ucwords(Str::before($permission->name, ' ')) }}</span>
                                            </label>
                                            <!--end::Checkbox-->
                                        </div>
                                        <!--end::Wrapper-->
                                    </td>
                                @endforeach
                                <!--end::Input group-->
                            </tr>
                            <!--end::Table row-->
                        @endforeach
                        <!--begin::Table row-->
                    </tbody>
                    <!--end::Table body-->
                </table>
                <!--end::Table-->
            </div>
            <!--end::Table wrapper-->
        </div>
        <!--end::Permissions-->
    </x-modal.form>
</div>
