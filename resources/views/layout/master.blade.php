<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" {!! printHtmlAttributes('html') !!}>
<!--begin::Head-->

<head>
    <base href="" />
    {{-- <title>{{ config('app.name', 'Laravel') }}</title> --}}
    <title>@yield('title')</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta charset="utf-8" />
    <meta name="description" content="" />
    <meta name="keywords" content="" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta property="og:locale" content="en_US" />
    <meta property="og:type" content="article" />
    <meta property="og:title" content="" />
    <link rel="canonical" href="{{ url()->current() }}" />

    {!! includeFavicon() !!}

    <!--begin::Fonts-->
    {!! includeFonts() !!}
    <!--end::Fonts-->

    <!--begin::Global Stylesheets Bundle(used by all pages)-->
    @foreach (getGlobalAssets('css') as $path)
        {!! sprintf('<link rel="stylesheet" href="%s">', asset($path)) !!}
    @endforeach
    <!--end::Global Stylesheets Bundle-->

    <!--begin::Vendor Stylesheets(used by this page)-->
    @foreach (getVendors('css') as $path)
        {!! sprintf('<link rel="stylesheet" href="%s">', asset($path)) !!}
    @endforeach
    <!--end::Vendor Stylesheets-->

    <!--begin::Custom Stylesheets(optional)-->
    @foreach (getCustomCss() as $path)
        {!! sprintf('<link rel="stylesheet" href="%s">', asset($path)) !!}
    @endforeach
    <!--end::Custom Stylesheets-->

    @livewireStyles
</head>
<!--end::Head-->

<!--begin::Body-->

@if ($pageDetail ?? false)
    {{ addHtmlAttribute('body', 'data-kt-app-sidebar-fixed', 'false') }}
@endif

<body {!! printHtmlClasses('body') !!} {!! printHtmlAttributes('body') !!}>

    @include('partials/theme-mode/_init')

    @yield('content')

    <!--begin::Javascript-->
    <!--begin::Global Javascript Bundle(mandatory for all pages)-->
    @foreach (getGlobalAssets() as $path)
        {!! sprintf('<script data-navigate-once src="%s"></script>', asset($path)) !!}
    @endforeach
    <!--end::Global Javascript Bundle-->

    <!--begin::Vendors Javascript(used by this page)-->
    @foreach (getVendors('js') as $path)
        {!! sprintf('<script data-navigate-once src="%s"></script>', asset($path)) !!}
    @endforeach
    <!--end::Vendors Javascript-->

    <!--begin::Custom Javascript(optional)-->
    @foreach (getCustomJs() as $path)
        {!! sprintf('<script data-navigate-once src="%s"></script>', asset($path)) !!}
    @endforeach
    <!--end::Custom Javascript-->
    @stack('scripts')
    <!--end::Javascript-->

    <script data-navigate-once>
        document.addEventListener('livewire:init', () => {
            // ================= Toastr =================
            Livewire.on('success', ([message, isCLose = true]) => {
                toastr.success(message);
                if (isCLose) {
                    $('.modal').modal('hide');
                    $('.modal').find('form').trigger('reset');
                }
            });
            Livewire.on('error', (message) => {
                toastr.error(message);
            });

            // ================= SweetAlert =================
            Livewire.on('swal', (message, icon, confirmButtonText) => {
                if (typeof icon === 'undefined') {
                    icon = 'success';
                }
                if (typeof confirmButtonText === 'undefined') {
                    confirmButtonText = 'Ok, got it!';
                }
                Swal.fire({
                    text: message,
                    icon: icon,
                    buttonsStyling: false,
                    timer: 2000,
                    confirmButtonText: confirmButtonText,
                    customClass: {
                        confirmButton: 'btn btn-primary'
                    }
                });
            });

            Livewire.on('swal-confirm', ([id, listener, more]) => {
                let [title, message, icon, confirmButtonText] = [
                    more?.title || 'Apakah Anda yakin?',
                    more?.text || 'Data yang dihapus tidak dapat dikembalikan!',
                    more?.icon || 'warning',
                    more?.confirmButtonText || 'Ok, got it!'
                ];

                Swal.fire({
                    title: title,
                    text: message,
                    icon: icon,
                    showCancelButton: true,
                    cancelButtonText: "Batal",
                    confirmButtonText: confirmButtonText,
                    buttonsStyling: false,
                    customClass: {
                        cancelButton: "btn btn-secondary",
                        confirmButton: "btn btn-danger",
                    }
                }).then((result) => {
                    if (result.isConfirmed) {

                        Livewire.dispatch(listener, [id, 'delete']);
                    } else if (result.dismiss === Swal.DismissReason.cancel) {
                        Swal.fire({
                            title: "Dibatalkan",
                            icon: "success",
                            timer: 2000,
                            confirmButtonText: "OK",
                            customClass: {
                                confirmButton: "btn btn-secondary"
                            }
                        });
                    }
                });
            });

            // ================= Select2 =================


        });
    </script>

    @livewireScripts
</body>
<!--end::Body-->

</html>
