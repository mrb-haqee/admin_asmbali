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

            var PageMenuSub = function() {
                if (@this === undefined) {
                    return;
                }

                $("#modal_menu_sub").on('hidden.bs.modal', function() {
                    if (@this.get('flag') === 'update') {
                        @this.call('resetFlag');
                    }
                });

                $('#table_menu [data-kt-action="update_row"]').each(function() {
                    $(this).on('click', function() {
                        @this.call('update', $(this).data('menu-id'));
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
                                @this.call('delete', [$(this).data('menu-id')]);
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

            Livewire.hook("morphed", () => {
                PageMenuSub();
            })

            PageMenuSub();
        });
    </script>
@endpush
