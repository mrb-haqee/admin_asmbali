<div class="modal fade" id="modal_{{ Str::snake($id) }}" tabindex="-1" aria-hidden="true" wire:ignore.self>
    <!--begin::Modal dialog-->
    <div class="modal-dialog {{ $sizeModal }} modal-dialog-centered">
        <!--begin::Modal content-->
        <div class="modal-content">
            <!--begin::Modal header-->
            <div class="modal-header">
                <!--begin::Modal title-->
                <h2 class="fw-bold">Form {{ Str::title(str_replace('_', ' ', $id)) }}</h2>
                <!--end::Modal title-->
                <!--begin::Close-->
                <div class="btn btn-icon btn-sm btn-active-icon-primary" data-bs-dismiss="modal" aria-label="Close"
                    wire:loading.attr="disabled">
                    {!! getIcon('cross', 'fs-1') !!}
                </div>
                <!--end::Close-->
            </div>
            <!--end::Modal header-->
            <!--begin::Modal body-->
            <div class="modal-body px-5 my-7">
                <form id="modal_{{ Str::snake($id) }}_modal_{{ Str::snake($id) }}_form" class="form" action="#"
                    wire:submit.prevent="submit" enctype="multipart/form-data">
                    <div class="d-flex flex-column scroll-y px-5 px-lg-10" id="modal_{{ Str::snake($id) }}_scroll"
                        data-kt-scroll="true" data-kt-scroll-activate="true" data-kt-scroll-max-height="auto"
                        data-kt-scroll-dependencies="#modal_{{ Str::snake($id) }}_header"
                        data-kt-scroll-wrappers="#modal_{{ Str::snake($id) }}_scroll" data-kt-scroll-offset="300px">
                        {{ $slot }}
                    </div>
                    <div class="text-center pt-15">
                        <button type="reset" class="btn btn-secondary me-3" data-bs-dismiss="modal" aria-label="Close"
                            wire:loading.attr="disabled">Close</button>
                        <button type="submit" class="btn {{ $flag === 'update' ? 'btn-info' : 'btn-primary' }}">
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
