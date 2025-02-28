<x-modal.container id="add_user">

    <div class="modal-header">
        <h2 class="fw-bold">Form Add Users</h2>
        <div class="btn btn-icon btn-sm btn-active-icon-primary" data-bs-dismiss="modal" aria-label="Close"
            wire:loading.attr="disabled">
            {!! getIcon('cross', 'fs-1') !!}
        </div>
    </div>

    <div class="modal-body px-5 my-7">
        <form class="form px-6" action="#" wire:submit.prevent="submit" enctype="multipart/form-data">

            <div wire:ignore class="fv-row mb-7">
                <label class="required fw-semibold fs-6 mb-2">Users</label>
                <select
                    onchange="@this.set('selectedUsers', Array.from(this.selectedOptions).map(option => option.value))"
                    id="selectedUsers" name="selectedUsers" class="form-select form-control-solid mb-3 mb-lg-0" multiple
                    wire:model.defer="selectedUsers" data-control="select2" data-placeholder="Select an option"
                    data-allow-clear="true">
                    @foreach ($users as $user)
                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                    @endforeach
                </select>
            </div>
            @error('selectedUsers')
                <div class="text-danger">{{ $message }}</div>
            @enderror


            <div class="text-center pt-15">
                <button type="reset" class="btn btn-secondary me-3" data-bs-dismiss="modal" aria-label="Close"
                    wire:loading.attr="disabled">Close</button>
                <button type="submit" class="btn btn-primary">
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
