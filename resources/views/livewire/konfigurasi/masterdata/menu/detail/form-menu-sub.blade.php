<x-modal.container id="menu_sub">

    <div class="modal-header">
        <h2 class="fw-bold">Form Menu Sub</h2>
        <div class="btn btn-icon btn-sm btn-active-icon-primary" data-bs-dismiss="modal" aria-label="Close"
            wire:loading.attr="disabled">
            {!! getIcon('cross', 'fs-1') !!}
        </div>
    </div>

    <div class="modal-body px-5 my-7">
        <form class="form px-6" action="#" wire:submit.prevent="submit" enctype="multipart/form-data">

            <div class="fv-row mb-7">
                <label class="required fw-semibold fs-6 mb-2">Name</label>
                <input type="text" wire:model.defer="name" name="name"
                    class="form-control form-control-solid mb-3 mb-lg-0" placeholder="Full name" />
                @error('name')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            <div class="mb-7">
                <label class="required fw-semibold fs-6 mb-5">Permission</label>
                @error('checked_permission')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
                <div class="row">
                    @foreach ($permissions as $index => $permission)
                        <div class="col-md-6 mb-2">
                            <div class="d-flex fv-row">
                                <div class="form-check form-check-custom form-check-solid">
                                    <input class="form-check-input me-3" wire:click="tgRoles('{{ $permission }}')"
                                        type="checkbox" @if (in_array($permission, $checked_permission)) checked @endif />
                                    <label class="form-check-label">
                                        <div class="fw-bold text-gray-800">
                                            {{ ucwords($permission) }}
                                        </div>
                                    </label>
                                </div>
                            </div>
                            @if (!$loop->last && $index % 2 == 1)
                            @endif
                        </div>
                    @endforeach
                </div>
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
