<div class="card">
    <!--begin::Card header-->
    <div class="card-header border-0 pt-6">
        <!--begin::Card title-->
        <div class="card-title">
            <!--begin::Search-->
            <div class="d-flex align-items-center position-relative my-1">
                {!! getIcon('magnifier', 'fs-3 position-absolute ms-5') !!}
                <input wire:model.live="search" type="text" class="form-control form-control-solid w-250px ps-13"
                    placeholder="Search permission" />
            </div>
            <!--end::Search-->
        </div>
        <!--begin::Card title-->
        <!--begin::Card toolbar-->
        <div class="card-toolbar">

        </div>
        <!--end::Card toolbar-->

    </div>
    <!--end::Card header-->

    <!--begin::Card body-->
    <div class="card-body py-4">
        <!--begin::Table-->
        <div class="table-responsive">
            <table id="table_menu" class="table table-row-bordered gy-5 gs-7">
                <thead class="">
                    <tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0">
                        <th style="width: 20%;">Name</th>
                        <th style="width: 60%;">assigned to</th>
                        <th style="width: 20%;">created at</th>
                    </tr>
                </thead>
                <tbody>

                    @if ($dataDaftar->isEmpty())
                        <x-table.data-not-found :colspan="4" />
                    @endif
                    @foreach ($dataDaftar as $row)
                        <tr class="fw-bold fs-7" wire:key="{{ $row->id }}">
                            <td class="text-muted fw-bold fs-5 align-middle"> {{ $row->name }} </td>
                            <td class="align-middle">
                                <div class="d-flex flex-wrap">
                                    @foreach ($row->roles as $role)
                                        <a href="{{ route('konfigurasi.aksesibilitas.roles.show', $role) }}"
                                            class="badge fs-7 m-1 {{ app(\App\Actions\GetThemeType::class)->handle('badge-light-?', $role->name) }}">
                                            {{ $role->name }}
                                        </a>
                                    @endforeach
                                </div>

                            </td>
                            <td class="text-nowrap text-muted align-middle">
                                {{ $row->created_at->format('d M Y, h:i a') }}
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
