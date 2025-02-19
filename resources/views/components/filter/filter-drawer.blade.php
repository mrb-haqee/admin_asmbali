<!--begin::View component-->
<div id="kt_drawer_example_basic" class="bg-white" data-kt-drawer="true" data-kt-drawer-activate="true"
    data-kt-drawer-toggle="#button_drawer" data-kt-drawer-close="#kt_drawer_example_basic_close"
    data-kt-drawer-width="{default:'300px', 'md': '400px'}">
    <div class="card rounded-0 w-100">
        <!--begin::Card header-->
        <div class="card-header pe-5">
            <!--begin::Title-->
            <div class="card-title">
                <!--begin::User-->
                <div class="d-flex justify-content-center flex-column me-3">
                    <a href="#" class="fs-4 fw-bold text-gray-900 text-hover-primary me-1 lh-1">Filter
                        Options</a>
                </div>
                <!--end::User-->
            </div>
            <!--end::Title-->

            <!--begin::Card toolbar-->
            <div class="card-toolbar">
                <!--begin::Close-->
                <div class="btn btn-sm btn-icon btn-active-light-primary" id="kt_drawer_example_basic_close">
                    <i class="ki-duotone ki-cross fs-2"><span class="path1"></span><span class="path2"></span></i>
                </div>
                <!--end::Close-->
            </div>
            <!--end::Card toolbar-->
        </div>
        <!--end::Card header-->

        <!--begin::Card body-->
        <div class="card-body hover-scroll-overlay-y">
            <div class="mb-5">
                <!--begin::Label-->
                <label class="form-label fs-5 fw-semibold mb-3 text-muted">
                    {!! getIcon('calendar-8', 'text-gray-500 fs-2', 'outline', 'i') !!} Range
                </label>
                <!--end::Label-->

                <!--begin::Input-->
                <div class="btn btn-light d-flex align-items-center justify-content-between" id="daterangepicker">
                    <!--begin::Display range-->
                    <span class="text-gray-600 fw-bold">
                        Select date
                    </span>
                    <input type="hidden" data-filter="drawer" name="range">
                    {!! getIcon('calendar-8', 'text-gray-500 lh-0 fs-2 ms-2 me-0', 'outline', 'i') !!}
                </div>
                <!--end::Input-->
            </div>
        </div>


        <!--begin::Card footer-->
        <div class="card-footer">
            <!--begin::Dismiss button-->
            <button class="btn btn-light-primary" data-kt-drawer-dismiss="true" id="button-filter">Apply</button>
            <!--end::Dismiss button-->
        </div>
        <!--end::Card footer-->
    </div>
</div>
<!--end::View component-->

@push('scripts')
    <script>
        function callback_daterangepicker(start, end) {
            let isToday = start.format("D MMM YY") === end.format("D MMM YY")
            let format = isToday ? 'D MMMM YYYY' : 'D MMM YY';

            if (isToday) {
                $("#daterangepicker span").html(start.format(format));
                $("input[name='range'][data-filter='drawer']").val(start.format('D-M-Y'))
            } else {
                $("input[name='range'][data-filter='drawer']").val(start.format('D-M-Y') + " - " +
                    end.format('D-M-Y'))
                $("#daterangepicker span").html(start.format(format) + " - " + end.format(
                    format));
            }
        }

        $(document).ready(function() {
            var start = moment().subtract(29, "days");
            var end = moment();
            callback_daterangepicker(start, end);

            $("#daterangepicker").daterangepicker({
                startDate: start,
                endDate: end,
                ranges: {
                    "Today": [moment(), moment()],
                    "Yesterday": [moment().subtract(1, "days"), moment().subtract(1, "days")],
                    "Last 7 Days": [moment().subtract(6, "days"), moment()],
                    "Last 30 Days": [moment().subtract(29, "days"), moment()],
                    "This Month": [moment().startOf("month"), moment().endOf("month")],
                    "Last Month": [moment().subtract(1, "month").startOf("month"), moment().subtract(1,
                        "month").endOf("month")]
                }
            }, callback_daterangepicker);

        });
    </script>
@endpush
