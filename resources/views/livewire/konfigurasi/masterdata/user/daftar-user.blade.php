<div>
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
                                <a href="{{ route('user-management.users.show', $user) }}">
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
                                    class="text-gray-800 text-hover-primary mb-1 text-start">
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
                        <a href="#" class="btn btn-light btn-active-light-primary btn-flex btn-center btn-sm"
                            data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
                            Actions
                            <i class="ki-duotone ki-down fs-5 ms-1"></i>
                        </a>
                        <!--begin::Menu-->
                        <x-button.button-action :data="['id' => $user->id]" :handle="[
                            'action' => 'show,edit,delete',
                            'idModal' => 'modal_menu',
                            'routeShow' => 'konfigurasi.masterdata.menu.show',
                        ]" />
                        <!--end::Menu-->
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    {{ $dataDaftar->links() }}
</div>





@push('scripts')
    <script data-navigate-once>
        $(document).ready(function() {
            $("input[data-filter='drawer']").each((i, element) => {
                @this.set($(element).attr('name'), $(element).val());
            })

            $("#menu input[data-filter='search']").on('change', function(e) {
                @this.set('search', e.target.value);
            });

            $("#button-filter").on('click', function(e) {
                @this.set('search', '');
                $("input[data-filter='drawer']").each((i, element) => {
                    @this.set($(element).attr('name'), $(element).val());
                })
            });

            Livewire.on('proses-selesai', function() {
                $('#modal_menu').modal('hide');
                // @this.call('getDataDaftar')
            })
        });
    </script>
@endpush
