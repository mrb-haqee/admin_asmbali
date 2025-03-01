<x-modal.container id="menu">

    <div class="modal-header">
        <h2 class="fw-bold">Form Menu</h2>
        <div class="btn btn-icon btn-sm btn-active-icon-primary" data-bs-dismiss="modal" aria-label="Close"
            wire:loading.attr="disabled">
            {!! getIcon('cross', 'fs-1') !!}
        </div>
    </div>

    <div class="modal-body px-5 my-7">
        <form class="form px-6" action="#" wire:submit.prevent="submit" enctype="multipart/form-data">

            <div class="fv-row mb-7">
                <label class="required fw-semibold fs-6 mb-2">Group</label>
                <div wire:ignore>
                    <select id="group" class="form-select form-control-solid mb-3 mb-lg-0" wire:model.defer="group"
                        data-control="select2" data-placeholder="Select an option" data-allow-clear="true"
                        data-hide-search="true" onchange="@this.set('group', this.value)">
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
                <div class="row">
                    <div class="col-md-4">
                        <label class=" fw-semibold fs-6 mb-2">Sub Menu</label>
                        <div class="form-check form-switch form-check-custom form-check-solid mb-3 mb-lg-0">
                            <input class="form-check-input " type="checkbox" id="option" wire:model.live="option"
                                name="option" />
                        </div>
                    </div>
                    <div class="col-md-5">
                        <label class=" fw-semibold fs-6 mb-2">Icon</label>
                        <input type="text" class="form-control form-control-solid mb-3 mb-lg-0"
                            placeholder="abstract-26" wire:model.live="icon" name="icon"
                            aria-describedby="basic-addon1" />
                    </div>
                    <div class="col-md-3 d-flex justify-content-center align-items-center">
                        <label class="d-block">&nbsp;</label>
                        {!! getIcon($icon ?? 'abstract-26', 'fs-4x', tag: 'i') !!}
                    </div>
                </div>
            </div>


            <div class="mb-7 @if ($option) d-none @endif">
                <label class="required fw-semibold fs-6 mb-5">Permission</label>
                @error('checked_permission')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
                <div class="row">
                    @foreach ($permissions as $index => $permission)
                        <div class="col-md-6 mb-2">
                            <div class="d-flex fv-row">
                                <div class="form-check form-check-custom form-check-solid">
                                    <input class="form-check-input me-3"
                                        wire:click="tgPermission('{{ $permission }}')" type="checkbox"
                                        @if (in_array($permission, $checked_permission)) checked @endif />
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
