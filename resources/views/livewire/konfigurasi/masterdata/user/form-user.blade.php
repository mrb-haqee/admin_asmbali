<div class="modal fade" id="modal_menu" tabindex="-1" aria-hidden="true" wire:ignore.self>
    <!--begin::Modal dialog-->
    <div class="modal-dialog modal-dialog-centered">
        <!--begin::Modal content-->
        <div class="modal-content">
            <!--begin::Modal header-->
            <div class="modal-header">
                <!--begin::Modal title-->
                <h2 class="fw-bold">Tambah User</h2>
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

                <form id="modal_menu_form" class="form" action="#" wire:submit.prevent="submit"
                    enctype="multipart/form-data">
                    <input type="hidden" wire:model.defer="menu_id" name="menu_id" />
                    <input type="hidden" wire:model.defer="flag" name="flag" />
                    <div class="d-flex flex-column scroll-y px-5 px-lg-10" id="modal_menu_scroll" data-kt-scroll="true"
                        data-kt-scroll-activate="true" data-kt-scroll-max-height="auto"
                        data-kt-scroll-dependencies="#modal_menu_header" data-kt-scroll-wrappers="#modal_menu_scroll"
                        data-kt-scroll-offset="300px">

                        <div class="fv-row mb-7">
                            <label class="d-block fw-semibold fs-6 mb-5">Avatar</label>
                            <style>
                                .image-input-placeholder {
                                    background-image: url('{{ image('svg/files/blank-image.svg') }}');
                                }

                                [data-bs-theme="dark"] .image-input-placeholder {
                                    background-image: url('{{ image('svg/files/blank-image-dark.svg') }}');
                                }
                            </style>
                            <div class="image-input image-input-outline image-input-placeholder {{ $avatar || $saved_avatar ? '' : 'image-input-empty' }}"
                                data-kt-image-input="true">
                                @if ($avatar)
                                    <div class="image-input-wrapper w-125px h-125px"
                                        style="background-image: url({{ $avatar ? $avatar->temporaryUrl() : '' }});">
                                    </div>
                                @else
                                    <div class="image-input-wrapper w-125px h-125px"
                                        style="background-image: url({{ $saved_avatar }});"></div>
                                @endif
                                <label
                                    class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                                    data-kt-image-input-action="change" data-bs-toggle="tooltip" title="Change avatar">
                                    {!! getIcon('pencil', 'fs-7') !!}
                                    <input type="file" wire:model="avatar" name="avatar"
                                        accept=".png, .jpg, .jpeg" />
                                    <input type="hidden" name="avatar_remove" />
                                </label>
                                <span
                                    class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                                    data-kt-image-input-action="cancel" data-bs-toggle="tooltip" title="Cancel avatar">
                                    {!! getIcon('cross', 'fs-2') !!}
                                </span>
                                <span
                                    class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                                    data-kt-image-input-action="remove" data-bs-toggle="tooltip" title="Remove avatar">
                                    {!! getIcon('cross', 'fs-2') !!}
                                </span>
                            </div>
                            <div class="form-text">Allowed file types: png, jpg, jpeg.</div>
                            @error('avatar')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>


                        <div class="fv-row mb-7">
                            <label class="required fw-semibold fs-6 mb-2">Name</label>
                            <input type="text" wire:model.defer="name" name="name"
                                class="form-control form-control-solid mb-3 mb-lg-0" placeholder="Full name" />
                            @error('name')
                                <span class="text-danger" wire:dirty.remove>{{ $message }}</span>
                            @enderror
                        </div>
                        <!--begin::Input group-->
                        <div class="fv-row mb-7">
                            <!--begin::Label-->
                            <label class="required fw-semibold fs-6 mb-2">Email</label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <input type="email" wire:model="email" name="email"
                                class="form-control form-control-solid mb-3 mb-lg-0" placeholder="example@domain.com" />
                            <!--end::Input-->
                            @error('email')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <!--end::Input group-->
                        <!--begin::Input group-->
                        <div class="mb-7">
                            <!--begin::Label-->
                            <label class="required fw-semibold fs-6 mb-5">Role</label>
                            <!--end::Label-->
                            @error('role')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                            <!--begin::Roles-->
                            @foreach ($roles as $role)
                                <!--begin::Input row-->
                                <div class="d-flex fv-row">
                                    <!--begin::Radio-->
                                    <div class="form-check form-check-custom form-check-solid">
                                        <!--begin::Input-->
                                        <input class="form-check-input me-3"
                                            id="kt_modal_update_role_option_{{ $role->id }}" wire:model="role"
                                            name="role" type="radio" value="{{ $role->name }}"
                                            checked="checked" />
                                        <!--end::Input-->
                                        <!--begin::Label-->
                                        <label class="form-check-label"
                                            for="kt_modal_update_role_option_{{ $role->id }}">
                                            <div class="fw-bold text-gray-800">
                                                {{ ucwords($role->name) }}
                                            </div>
                                            <div class="text-gray-600">
                                                {{ $role->description }}
                                            </div>
                                        </label>
                                        <!--end::Label-->
                                    </div>
                                    <!--end::Radio-->
                                </div>
                                <!--end::Input row-->
                                @if (!$loop->last)
                                    <div class='separator separator-dashed my-5'></div>
                                @endif
                            @endforeach
                            <!--end::Roles-->
                        </div>
                        <!--end::Input group-->
                    </div>
                    <div class="text-center pt-15">
                        <button type="reset" class="btn btn-secondary me-3" data-bs-dismiss="modal" aria-label="Close"
                            wire:loading.attr="disabled" wire:target="resetFlag">Close</button>
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

@push('scripts')
    <script>
        $(document).ready(function() {

            var PageMenu = function() {
                if (@this === undefined) {
                    return;
                }

                $("#modal_menu [data-control='select2']").select2().on('change', function() {
                    @this.set($(this).data('select'), $(this).val())
                });

                $("#modal_menu").on('hidden.bs.modal', function() {
                    if (@this.get('flag') === 'update') {
                        @this.call('resetFlag');
                    }
                });

                $('#table_menu [data-kt-action="update_row"]').each(function() {
                    $(this).on('click', function() {
                        @this.call('update', $(this).data('data-id'));
                    });
                });

                $('#table_menu [data-kt-action="delete_row"]').each(function() {
                    $(this).on('click', function(e) {
                        e.preventDefault();
                        Swal.fire({
                            title: "Apakah Anda yakin?",
                            text: "Data yang dihapus tidak dapat dikembalikan!",
                            icon: "warning",
                            showCancelButton: true,
                            cancelButtonText: "Batal",
                            confirmButtonText: "Ya, hapus!",
                            buttonsStyling: false,
                            customClass: {
                                cancelButton: "btn btn-secondary",
                                confirmButton: "btn btn-danger",
                            }
                        }).then((result) => {
                            if (result.isConfirmed) {
                                @this.call('delete', [$(this).data('data-id')]);
                            } else if (result.dismiss === Swal.DismissReason
                                .cancel) {
                                Swal.fire({
                                    title: "Dibatalkan",
                                    text: "Data Anda aman dan tidak dihapus.",
                                    icon: "success",
                                    timer: 2000,
                                    confirmButtonText: "OK",
                                    customClass: {
                                        confirmButton: "btn btn-secondary"
                                    }
                                });
                            }
                        });
                    });
                });

                KTMenu.createInstances();
            };

            PageMenu();

            Livewire.hook("morphed", () => {
                PageMenu();
            })

        });
    </script>
@endpush
