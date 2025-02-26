<div class="modal fade" id="modal_menu_sub" tabindex="-1" aria-hidden="true" wire:ignore.self>
    <!--begin::Modal dialog-->
    <div class="modal-dialog modal-dialog-centered">
        <!--begin::Modal content-->
        <div class="modal-content">
            <!--begin::Modal header-->
            <div class="modal-header">
                <!--begin::Modal title-->
                <h2 class="fw-bold">Tambah Menu Sub</h2>
                <!--end::Modal title-->
                <!--begin::Close-->
                <div class="btn btn-icon btn-sm btn-active-icon-primary" data-bs-dismiss="modal" aria-label="Close">
                    {!! getIcon('cross', 'fs-1') !!}
                </div>
                <!--end::Close-->
            </div>
            <!--end::Modal header-->
            <!--begin::Modal body-->
            <div class="modal-body px-5 my-7">

                <form id="modal_menu_sub_form" class="form" action="#" wire:submit.prevent="submit"
                    enctype="multipart/form-data">
                    <div class="d-flex flex-column scroll-y px-5 px-lg-10" id="modal_menu_sub_scroll"
                        data-kt-scroll="true" data-kt-scroll-activate="true" data-kt-scroll-max-height="auto"
                        data-kt-scroll-dependencies="#modal_menu_sub_header"
                        data-kt-scroll-wrappers="#modal_menu_sub_scroll" data-kt-scroll-offset="300px">

                        <div class="fv-row mb-7">
                            <label class="required fw-semibold fs-6 mb-2">Name</label>
                            <input type="text" wire:model.defer="name" name="name"
                                class="form-control form-control-solid mb-3 mb-lg-0" placeholder="Full name" />
                            @error('name')
                                <span class="text-danger" wire:dirty.remove>{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-7">
                            <label class="required fw-semibold fs-6 mb-5">Role</label>
                            @error('roles')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                            @foreach ($data_roles as $role)
                                <div class="d-flex fv-row">
                                    <div class="form-check form-check-custom form-check-solid">
                                        <input class="form-check-input me-3"
                                            wire:click="toggleRoles('{{ $role->id }}')" type="checkbox"
                                            @if (in_array($role->id, $roles)) checked @endif />
                                        <label class="form-check-label">
                                            <div class="fw-bold text-gray-800">
                                                {{ ucwords($role->name) }}
                                            </div>
                                            <div class="text-gray-600">
                                                {{ $role->description }}
                                            </div>
                                        </label>
                                    </div>
                                </div>
                                @if (!$loop->last)
                                    <div class='separator separator-dashed my-5'></div>
                                @endif
                            @endforeach
                        </div>

                    </div>
                    <div class="text-center pt-15">
                        <button type="reset" class="btn btn-secondary me-3" data-bs-dismiss="modal" aria-label="Close"
                            wire:loading.attr="disabled">Close</button>
                        <button type="submit" class="btn {{ $flag === 'update' ? 'btn-info' : 'btn-primary' }}"
                            data-kt-users-modal-action="submit">
                            <span class="indicator-label" wire:loading.remove>Submit</span>
                            <span class="indicator-progress" wire:loading wire:target="submit">
                                Please wait...
                                <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                            </span>
                        </button>
                    </div>
                </form>

            </div>
            <!--end::Modal body-->
        </div>
        <!--end::Modal content-->
    </div>
    <!--end::Modal dialog-->
</div>
