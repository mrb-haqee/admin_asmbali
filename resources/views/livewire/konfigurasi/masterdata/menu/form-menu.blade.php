<div class="modal fade" id="modal_menu" tabindex="-1" aria-hidden="true" wire:ignore.self>
    <!--begin::Modal dialog-->
    <div class="modal-dialog modal-dialog-centered">
        <!--begin::Modal content-->
        <div class="modal-content">
            <!--begin::Modal header-->
            <div class="modal-header">
                <!--begin::Modal title-->
                <h2 class="fw-bold">From Menu</h2>
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
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="fv-row mb-7">
                            <label class="required fw-semibold fs-6 mb-2">Name</label>
                            <input type="text" wire:model.defer="name" name="name"
                                class="form-control form-control-solid mb-3 mb-lg-0" placeholder="Full name" />
                            @error('name')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="fv-row mb-7">
                            <label class=" fw-semibold fs-6 mb-2">Sub Menu</label>
                            <div class="form-check form-switch form-check-custom form-check-solid">
                                <input class="form-check-input" type="checkbox" id="option" wire:model.live="option"
                                    name="option" />
                            </div>
                        </div>

                        @if (!$option)
                            <div class="fv-row mb-7">
                                <label class="fw-semibold fs-6 mb-2">Permission</label>
                                <div class="d-flex flex-wrap">
                                    @foreach ($data_permission as $permission)
                                        <div
                                            class="form-check form-check-custom form-check-solid form-check-sm mb-2 me-3">
                                            <input class="form-check-input" type="checkbox"
                                                wire:click="togglePermission('{{ $permission }}')"
                                                @if (in_array($permission, $checked_permission)) checked @endif />
                                            <label class="form-check-label">
                                                {{ ucwords($permission) }}
                                            </label>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif

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
            $(document).on('change', "#modal_menu [data-control='select2']", function() {
                @this.set('group', $(this).val())
            });
        });
    </script>
@endpush
