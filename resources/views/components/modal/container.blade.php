<div class="modal fade" id="modal_{{ Str::snake($id) }}" tabindex="-1" aria-hidden="true" wire:ignore.self>
    <!--begin::Modal dialog-->
    <div class="modal-dialog {{ $sizeModal }} modal-dialog-centered">
        <!--begin::Modal content-->
        <div class="modal-content">
            {{ $slot }}
        </div>
        <!--end::Modal content-->
    </div>
    <!--end::Modal dialog-->
</div>
