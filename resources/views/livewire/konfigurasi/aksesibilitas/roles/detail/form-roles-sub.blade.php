<div class="modal fade" id="modal_add_user" tabindex="-1" aria-hidden="true" wire:ignore.self>
    <!--begin::Modal dialog-->
    <div class="modal-dialog modal-dialog-centered">
        <!--begin::Modal content-->
        <div class="modal-content">
            <!--begin::Modal header-->
            <div class="modal-header">
                <!--begin::Modal title-->
                <h2 class="fw-bold">User</h2>
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

                <form id="modal_add_user_form" class="form" action="#" wire:submit.prevent="submit"
                    enctype="multipart/form-data">
                    <div class="d-flex flex-column scroll-y px-5 px-lg-10" id="modal_add_user_scroll"
                        data-kt-scroll="true" data-kt-scroll-activate="true" data-kt-scroll-max-height="auto"
                        data-kt-scroll-dependencies="#modal_add_user_header"
                        data-kt-scroll-wrappers="#modal_add_user_scroll" data-kt-scroll-offset="300px">
                        {{ dump($dataDaftar->count()) }}
                        <div class="fv-row mb-7">
                            <label class="required fw-semibold fs-6 mb-2">Users</label>
                            <div wire:ignore>
                                <select id="users" name="users[]"
                                    class="form-select form-control-solid mb-3 mb-lg-0" multiple
                                    wire:model.defer="users" data-select="users" data-control="select2"
                                    data-placeholder="Select an option" data-allow-clear="true" data-hide-search="true">
                                    @foreach ($dataDaftar as $user)
                                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            @error('users')
                                <span class="text-danger" wire:dirty.remove>{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="text-center pt-15">

                        <button type="reset" class="btn btn-secondary me-3" data-bs-dismiss="modal" aria-label="Close"
                            wire:loading.attr="disabled" wire:target="resetFlag">Close</button>

                        <button type="submit" class="btn btn-primary" data-kt-users-modal-action="submit">
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
    <script data-navigate-once>
        $(document).ready(function() {
            $('#modal_add_user_form [data-control="select2"]').off('change').on('change', function() {
                var users = $(this).val();
                @this.set('users', users);
            });

            Livewire.on('success', (message) => {
                $(this).find('option:selected').remove();
            });

            Livewire.hook('morph', () => {
                KTMenu.createInstances();
            })

        });
    </script>
@endpush
