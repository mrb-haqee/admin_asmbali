<!--begin::Layout-->
<div class="d-flex flex-column flex-lg-row">
    <!--begin::Sidebar-->
    <div class="flex-column flex-lg-row-auto w-100 w-lg-200px w-xl-300px mb-10">
        <!--begin::Card-->
        <div class="card card-flush">
            <!--begin::Card header-->
            <div class="card-header">
                <!--begin::Card title-->
                <div class="card-title">
                    <h2 class="mb-0">{{ ucwords($role->name) }}</h2>
                </div>
                <!--end::Card title-->
            </div>
            <!--end::Card header-->
            <!--begin::Card body-->
            <div class="card-body pt-0">
                <!--begin::Permissions-->
                <div class="d-flex flex-column text-gray-600">
                    @foreach ($role->permissions->shuffle()->take(5) as $permission)
                        <div class="d-flex align-items-center py-2">
                            <span class="bullet bg-primary me-3"></span>
                            {{ ucfirst($permission->name) }}
                        </div>
                    @endforeach
                    @if ($role->permissions->count() > 5)
                        <div class="d-flex align-items-center py-2">
                            <span class='bullet bg-primary me-3'></span>
                            <em>and {{ $role->permissions->count() - 5 }} more...</em>
                        </div>
                    @endif
                    @if ($role->permissions->count() === 0)
                        <div class="d-flex align-items-center py-2">
                            <span class='bullet bg-primary me-3'></span>
                            <em>No permissions given...</em>
                        </div>
                    @endif
                </div>
                <!--end::Permissions-->
            </div>
            <!--end::Card body-->
            <!--begin::Card footer-->
            <div class="card-footer pt-0">
                <button wire:click="$dispatch('aksesibilitas.roles.from', { id: @js($role->id) })"
                    class="btn btn-light btn-active-primary" data-bs-toggle="modal" data-bs-target="#modal_role">
                    Edit Role
                </button>
            </div>
            <!--end::Card footer-->
        </div>
        <!--end::Card-->
    </div>
    <!--end::Sidebar-->
    <!--begin::Content-->
    <div class="flex-lg-row-fluid ms-lg-10">
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
                        <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal"
                            data-bs-target="#modal_add_user"
                            wire:click="$dispatch('gaspokoe', @js($role->id))">
                            {!! getIcon('plus-square', 'fs-2 ', 'outline', 'i') !!}
                            User
                        </button>
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
                                <th style="width: 20%;">User</th>
                                <th style="width: 20%;">Role</th>
                                <th style="width: 20%;">last_login_at </th>
                                <th style="width: 20%;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($dataDaftar as $i => $user)
                                <tr wire:key='{{ $user->id }}'>
                                    <td>
                                        <div class="d-flex justify-content-start align-items-center">
                                            <!--begin:: Avatar -->
                                            <div class="symbol symbol-circle symbol-50px overflow-hidden me-3">
                                                <a href="{{ route('user-management.users.show', $user) }}"
                                                    wire:navigate>
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
                                                <a href="{{ route('user-management.users.show', $user) }}"
                                                    class="text-gray-800 text-hover-primary mb-1 text-start"
                                                    wire:navigate>
                                                    {{ $user->name }}
                                                </a>
                                                <span class="text-muted">{{ $user->email }}</span>
                                            </div>
                                            <!--begin::User details-->
                                        </div>
                                    </td>
                                    <td>
                                        <div class="badge badge-light fw-bold">
                                            {{ $user->roles->first()?->name }}
                                        </div>
                                    </td>
                                    <td>
                                        <div class="badge badge-light fw-bold">
                                            {{ empty($user->last_login_at) ? $user->updated_at->diffForHumans() : $user->last_login_at->diffForHumans() }}
                                        </div>
                                    </td>

                                    <td>
                                        <div>
                                            <a href="#"
                                                class="btn btn-light btn-active-light-primary btn-flex btn-center btn-sm"
                                                data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
                                                Actions
                                                <i class="ki-duotone ki-down fs-5 ms-1"></i>
                                            </a>
                                            <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-125px py-4"
                                                data-kt-menu="true">
                                                <!--begin::Menu item-->
                                                <div class="menu-item px-3">
                                                    <a href="#" class="menu-link px-3"
                                                        wire:click="$dispatch('aksesibilitas.roles.detail.delete', @js(['id' => $user->id, 'flag' => 'confirm']))">
                                                        <i class="fas fa-trash me-3"></i>Delete
                                                    </a>
                                                </div>
                                                <!--end::Menu item-->
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    {{-- {{ $dataDaftar->links() }} --}}
                </div>
                <!--end::Table-->
            </div>
            <!--end::Card body-->
        </div>
        <!--end::Card-->
    </div>
    <!--end::Content-->
</div>
<!--end::Layout-->
