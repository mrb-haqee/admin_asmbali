<x-modal.container id="roles" sizeModal="modal-xl">

    <div class="modal-header">
        <h2 class="fw-bold">Form Roles</h2>
        <div class="btn btn-icon btn-sm btn-active-icon-primary" data-bs-dismiss="modal" aria-label="Close"
            wire:loading.attr="disabled">
            {!! getIcon('cross', 'fs-1') !!}
        </div>
    </div>

    <div class="modal-body px-5 my-7">
        <form class="form px-6" action="#" wire:submit.prevent="submit" enctype="multipart/form-data">

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
                <label class="required fs-5 fw-bold form-label mb-2">Role Permissions</label>
                <br>
                @error('checked_permissions')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
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
                                                        wire:model="checked_permissions"
                                                        value="{{ $permission->name }}" />
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


            <div class="text-center pt-15">
                <button type="reset" class="btn btn-secondary me-3" data-bs-dismiss="modal" aria-label="Close"
                    wire:loading.attr="disabled">Close</button>
                <button type="submit" class="btn btn-primary">
                    <span class="indicator-label" wire:loading.remove>Submit</span>
                    <span class="indicator-progress" wire:loading wire:target="submit">
                        Please wait...
                        <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                    </span>
                </button>
            </div>
        </form>
    </div>

</x-modal.container>
