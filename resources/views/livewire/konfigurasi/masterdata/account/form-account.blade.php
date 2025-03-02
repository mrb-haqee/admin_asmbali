<x-modal.container id="account">

    <div class="modal-header">
        <h2 class="fw-bold">Form Account</h2>
        <div class="btn btn-icon btn-sm btn-active-icon-primary" data-bs-dismiss="modal" aria-label="Close"
            wire:loading.attr="disabled">
            {!! getIcon('cross', 'fs-1') !!}
        </div>
    </div>

    <div class="modal-body px-5 my-7">
        <form class="form px-6" action="#" wire:submit.prevent="submit" enctype="multipart/form-data">

            <div class="fv-row mb-7">
                <label class="required fw-semibold fs-6 mb-2">Kode</label>
                <input type="text" wire:model.defer="kode" name="kode"
                    class="form-control form-control-solid mb-3 mb-lg-0" placeholder="Kode Account" />
                @error('name')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            <div class="fv-row mb-7">
                <label class="required fw-semibold fs-6 mb-2">Name</label>
                <input type="text" wire:model.defer="name" name="name"
                    class="form-control form-control-solid mb-3 mb-lg-0" placeholder="Name Acoount" />
                @error('name')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            {{-- <div class="fv-row mb-7 rounded border d-flex flex-column p-10">
                <label for="" class="form-label">Keterangen</label>
                <textarea class="form-control form-control form-control-solid" data-kt-autosize="true"></textarea>
            </div> --}}

            <div class="text-center pt-15">
                <button type="reset" class="btn btn-secondary me-3" data-bs-dismiss="modal" aria-label="Close"
                    wire:loading.attr="disabled">Close</button>
                <button type="submit" class="btn {{ $flag === 'tambah' ? 'btn-primary' : 'btn-info' }}">
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
