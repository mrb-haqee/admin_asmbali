<x-modal.container id="users">

    <div class="modal-header">
        <h2 class="fw-bold">Form User</h2>
        <div class="btn btn-icon btn-sm btn-active-icon-primary" data-bs-dismiss="modal" aria-label="Close"
            wire:loading.attr="disabled">
            {!! getIcon('cross', 'fs-1') !!}
        </div>
    </div>

    <div class="modal-body px-5 my-7">
        <form class="form px-6" action="#" wire:submit.prevent="submit" enctype="multipart/form-data">

            {{-- START FORM --}}
            <div class="fv-row mb-7">
                <label class="d-block fw-semibold fs-6 mb-5">Avatar</label>
                <style>
                    .image-input-placeholder {
                        background-image: url('{{ image('svg/files/blank-image.svg') }}');
                    }

                    [data-bs-theme="dark"] .image-input-placeholder {
                        background-image: url('{{ image('svg/files/blank-image-dark.svg') }}');
                    }
                </style>
                <div class="image-input image-input-outline image-input-placeholder {{ $avatar || $saved_avatar ? '' : 'image-input-empty' }}"
                    data-kt-image-input="true">
                    @if ($avatar)
                        <div class="image-input-wrapper w-125px h-125px"
                            style="background-image: url({{ $avatar ? $avatar->temporaryUrl() : '' }});">
                        </div>
                    @else
                        <div class="image-input-wrapper w-125px h-125px"
                            style="background-image: url({{ $saved_avatar }});"></div>
                    @endif
                    <label class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                        data-kt-image-input-action="change" data-bs-toggle="tooltip" title="Change avatar">
                        {!! getIcon('pencil', 'fs-7') !!}
                        <input type="file" wire:model.defer="avatar" name="avatar" accept=".png, .jpg, .jpeg" />
                        <input type="hidden" name="avatar_remove" />
                    </label>
                    <span class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                        data-kt-image-input-action="cancel" data-bs-toggle="tooltip" title="Cancel avatar">
                        {!! getIcon('cross', 'fs-2') !!}
                    </span>
                    <span class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                        data-kt-image-input-action="remove" data-bs-toggle="tooltip" title="Remove avatar">
                        {!! getIcon('cross', 'fs-2') !!}
                    </span>
                </div>
                <div class="form-text">Allowed file types: png, jpg, jpeg.</div>
                @error('avatar')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>


            <div class="fv-row mb-7">
                <label class="required fw-semibold fs-6 mb-2">Name</label>
                <input type="text" wire:model.defer="name" class="form-control form-control-solid mb-3 mb-lg-0"
                    placeholder="Full name" />
                @error('name')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="fv-row mb-7">
                <label class="required fw-semibold fs-6 mb-2">Username</label>
                <input type="text" wire:model.defer="email" name="email"
                    class="form-control form-control-solid mb-3 mb-lg-0" placeholder="@username" />
                @error('email')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-7">
                <label class="required fw-semibold fs-6 mb-5">Role</label>
                @error('role')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
                @foreach ($roles as $role)
                    <div class="d-flex fv-row">
                        <div class="form-check form-check-custom form-check-solid">
                            <input class="form-check-input me-3" wire:model.defer="role" type="radio"
                                value="{{ $role->name }}" />
                            <label class="form-check-label">
                                <div class="fw-bold text-gray-800">
                                    {{ ucwords($role->name) }}
                                </div>
                                <div class="text-gray-600">
                                    {{ $role->description }}
                                </div>
                            </label>
                        </div>
                    </div>
                    @if (!$loop->last)
                        <div class='separator separator-dashed my-5'></div>
                    @endif
                @endforeach
            </div>


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
