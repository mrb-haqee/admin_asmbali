<div class="modal fade" id="modal_menu" tabindex="-1" aria-hidden="true" wire:ignore.self>
    <!--begin::Modal dialog-->
    <div class="modal-dialog modal-dialog-centered">
        <!--begin::Modal content-->
        <div class="modal-content">
            <!--begin::Modal header-->
            <div class="modal-header">
                <!--begin::Modal title-->
                <h2 class="fw-bold">Tambah Menu</h2>
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
                            <label class="required fw-semibold fs-6 mb-2">Group</label>
                            <div wire:ignore>
                                <select id="group" class="form-select form-control-solid mb-3 mb-lg-0"
                                    wire:model.defer="group" data-select="group" data-control="select2"
                                    data-placeholder="Select an option" data-allow-clear="true" data-hide-search="true">
                                    <option></option>
                                    <option value="konfigurasi">Konfigurasi</option>
                                    <option value="administrasi">Administrasi</option>
                                    <option value="web_asm">Web ASM</option>
                                    <option value="web_tpq">Web TPQ</option>
                                </select>
                            </div>
                            @error('group')
                                <span class="text-danger" wire:dirty.remove>{{ $message }}</span>
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
                        <div class="form-check form-switch form-check-custom form-check-solid">
                            <input class="form-check-input" type="checkbox" value="" id="option"
                                wire:model.defer="option" name="option" />
                            <label class="form-check-label" for="option">
                                Sub Menu
                            </label>
                        </div>
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
