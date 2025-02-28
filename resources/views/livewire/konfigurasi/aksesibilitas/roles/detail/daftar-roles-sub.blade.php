<!--begin::Card-->
<div class="card card-flush mb-6 mb-xl-9">
    <!--begin::Card header-->
    <div class="card-header pt-5">
        <!--begin::Card title-->
        <div class="card-title">
            <h2 class="d-flex align-items-center">Users Assigned
                <span class="text-gray-600 fs-6 ms-1">({{ $role->users->count() }})</span>
            </h2>
        </div>
        <!--end::Card title-->
        <!--begin::Card toolbar-->
        <div class="card-toolbar">
            <!--begin::Toolbar-->
            <div class="d-flex justify-content-end" data-kt-customer-table-toolbar="base">

                <!--begin::Add customer-->
                @if (empty($checked_data))
                    <button wire:click="$dispatchTo('roles.detail.form-add-user-roles', '$refresh')"
                        wire:loading.attr="disabled" class="btn btn-primary btn-sm" data-bs-toggle="modal"
                        data-bs-target="#modal_add_user">
                        {!! getIcon('plus-square', 'fs-2 ', 'outline', 'i') !!}
                        User
                    </button>
                @else
                    <button wire:click="deleteChecked('confirm')" wire:loading.attr="disabled"
                        class="btn btn-danger btn-sm">
                        {!! getIcon('trash', 'fs-2 ', 'outline', 'i') !!}
                        Delete
                    </button>
                @endif
                <!--end::Add customer-->
            </div>
            <!--end::Toolbar-->

        </div>
        <!--end::Card toolbar-->
    </div>
    <!--end::Card header-->
    <!--begin::Card body-->
    <div class="card-body pt-0">
        <!--begin::Table-->
        <div class="table-responsive">
            <table id="table_menu" class="table table-row-bordered gy-5 gs-7">
                <thead>
                    <tr class="fw-bold fs-6 text-gray-800">
                        <th style="width: 1%;" class="d-none d-sm-table-cell"></th>
                        <th style="width: 20%;">User</th>
                        <th style="width: 20%;">Role</th>
                        <th style="width: 20%;">last_login_at </th>
                        <th style="width: 20%;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($dataDaftar as $i => $user)
                        <tr wire:key='{{ $user->id }}'>
                            <td class="align-middle d-none d-sm-table-cell ">
                                <!--begin::Checkbox-->
                                <label class="form-check form-check-sm form-check-custom form-check-solid me-9">
                                    <input class="form-check-input" type="checkbox"
                                        wire:click="tgCheck({{ $user->id }})" />
                                </label>
                                <!--end::Checkbox-->
                            </td>
                            <td class="align-middle">
                                <div class="d-flex justify-content-start align-items-center">
                                    <!--begin:: Avatar -->
                                    <div
                                        class="symbol symbol-circle symbol-50px overflow-hidden me-3 d-none d-sm-block">
                                        <a href="{{ route('konfigurasi.masterdata.user.index', $user) }}">
                                            @if ($user->profile_photo_url)
                                                <div class="symbol-label">
                                                    <img src="{{ $user->profile_photo_url }}" class="w-100" />
                                                </div>
                                            @else
                                                <div
                                                    class="symbol-label fs-3 {{ app(\App\Actions\GetThemeType::class)->handle('bg-light-? text-?', $user->name) }}">
                                                    {{ substr($user->name, 0, 1) }}
                                                </div>
                                            @endif
                                        </a>
                                    </div>
                                    <!--end::Avatar-->
                                    <!--begin::User details-->
                                    <div class="d-flex flex-column justify-content-start fw-bold">
                                        <a href="{{ route('konfigurasi.masterdata.user.index', $user) }}"
                                            class="text-gray-800 text-hover-primary mb-1 text-start">
                                            {{ $user->name }}
                                        </a>
                                        <span class="text-muted d-none d-sm-block">{{ $user->email }}</span>
                                    </div>
                                    <!--begin::User details-->
                                </div>
                            </td>
                            <td class="align-middle">
                                <div class="badge badge-light fw-bold">
                                    {{ $user->roles->first()?->name }}
                                </div>
                            </td>
                            <td class="align-middle">
                                <div class="badge badge-light fw-bold">
                                    {{ empty($user->last_login_at) ? $user->updated_at->diffForHumans() : $user->last_login_at->diffForHumans() }}
                                </div>
                            </td>

                            <td class="align-middle">
                                <x-button.dropdown>
                                    <div class="menu-item px-3">
                                        <a wire:click="delete('confirm', {{ $user->id }})" class="menu-link px-3">
                                            <i class="fas fa-trash me-3"></i>Delete
                                        </a>
                                    </div>
                                </x-button.dropdown>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            {{ $dataDaftar->links() }}
        </div>
        <!--end::Table-->
    </div>
    <!--end::Card body-->
</div>
<!--end::Card-->
