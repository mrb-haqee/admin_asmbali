<div class="card">
    <div class="card-header border-0 pt-6">
        <div class="card-title">
            <div class="d-flex align-items-center position-relative my-1">
                {!! getIcon('magnifier', 'fs-3 position-absolute ms-5') !!}
                <input wire:model.live.debounce.300ms="search" type="text"
                    class="form-control form-control-solid w-250px ps-13" placeholder="Search Menu" />
            </div>
        </div>


        <div class="card-toolbar">
            <div class="d-flex justify-content-end" data-kt-customer-table-toolbar="base">
                <button wire:click="$dispatchTo('{{ $pathForm }}','setForm', {id: null})" class="btn btn-primary"
                    data-bs-toggle="modal" data-bs-target="#modal_users">
                    {!! getIcon('plus-square', 'fs-2 ', 'outline', 'i') !!}
                    User
                </button>
            </div>

        </div>
    </div>

    <div class="card-body py-4">
        <div class="table-responsive">
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
                                        <div class="symbol symbol-circle symbol-50px overflow-hidden me-3">
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
                                        <div class="d-flex flex-column justify-content-start fw-bold">
                                            <a href="{{ route('konfigurasi.masterdata.user.index', $user) }}"
                                                class="text-gray-800 text-hover-primary mb-1 text-start">
                                                {{ $user->name }}
                                            </a>
                                            <span class="text-muted">{{ $user->email }}</span>
                                        </div>
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
                                    <x-button.dropdown>
                                        <div class="menu-item px-3">
                                            <a wire:navigate
                                                href="{{ route('konfigurasi.masterdata.user.index', $user) }}"
                                                class="menu-link px-3">
                                                <i class="fas fa-list me-3"></i>Detail
                                            </a>
                                            <a wire:click="$dispatchTo('{{ $pathForm }}','setForm', {id: {{ $user->id }} })"
                                                class="menu-link px-3" data-bs-toggle="modal"
                                                data-bs-target="#modal_users">
                                                <i class="fas fa-edit me-3"></i>Edit
                                            </a>
                                            <a wire:click="delete('confirm', {{ $user->id }})"
                                                class="menu-link px-3">
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
        </div>
    </div>
</div>
