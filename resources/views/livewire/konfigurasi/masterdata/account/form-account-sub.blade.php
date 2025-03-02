<x-modal.container id="account_sub">

    <div class="modal-header">
        <h2 class="fw-bold">Form Account Sub</h2>
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
                    class="form-control form-control-solid mb-3 mb-lg-0" placeholder="Kode Account Sub" />
                @error('name')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            <div class="fv-row mb-7">
                <label class="required fw-semibold fs-6 mb-2">Name</label>
                <input type="text" wire:model.defer="name" name="name"
                    class="form-control form-control-solid mb-3 mb-lg-0" placeholder="Name Acoount Sub" />
                @error('name')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            <div class="fv-row mb-7">
                <label for="" class="form-label">Keterangan</label>
                <textarea wire:model.defer="keterangan" name="keterangan" class="form-control form-control form-control-solid"
                    placeholder="Keterangan" data-kt-autosize="true"></textarea>
            </div>

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
