<!--begin::sidebar menu-->
<div class="app-sidebar-menu overflow-hidden flex-column-fluid">
    <!--begin::Menu wrapper-->
    <div id="kt_app_sidebar_menu_wrapper" class="app-sidebar-wrapper hover-scroll-overlay-y my-5" data-kt-scroll="true"
        data-kt-scroll-activate="true" data-kt-scroll-height="auto"
        data-kt-scroll-dependencies="#kt_app_sidebar_logo, #kt_app_sidebar_footer"
        data-kt-scroll-wrappers="#kt_app_sidebar_menu" data-kt-scroll-offset="5px" data-kt-scroll-save-state="true">
        <!--begin::Menu-->
        <div class="menu menu-column menu-rounded menu-sub-indention px-3 fw-semibold fs-6" id="#kt_app_sidebar_menu"
            data-kt-menu="true" data-kt-menu-expand="false">
            {{-- * START MENU DASHBOARD / WIDGET --}}
            <!--begin:Menu item-->
            <div data-kt-menu-trigger="click"
                class="menu-item menu-accordion {{ request()->routeIs('dashboard') ? 'here show' : '' }}">
                <!--begin:Menu link-->
                <span class="menu-link">
                    <span class="menu-icon">{!! getIcon('element-11', 'fs-2') !!}</span>
                    <span class="menu-title">Dashboards</span>
                    <span class="menu-arrow"></span>
                </span>
                <!--end:Menu link-->
                <!--begin:Menu sub-->
                <div class="menu-sub menu-sub-accordion">
                    <!--begin:Menu item-->
                    <div class="menu-item">
                        <!--begin:Menu link-->
                        <a class="menu-link {{ request()->routeIs('dashboard') ? 'active' : '' }}"
                            href="{{ route('dashboard') }}" wire:navigate>
                            <span class="menu-bullet">
                                <span class="bullet bullet-dot"></span>
                            </span>
                            <span class="menu-title">Default</span>
                        </a>
                        <!--end:Menu link-->
                    </div>
                    <!--end:Menu item-->
                </div>
                <!--end:Menu sub-->
            </div>
            <!--end:Menu item-->
            {{-- * END MENU DASHBOARD / WIDGET --}}


            {{-- * START ADMINISTRASI --}}
            @foreach ($menus as $kop => $menu)
                <!--begin:Menu item-->
                <div class="menu-item pt-5">
                    <!--begin:Menu content-->
                    <div class="menu-content">
                        <span class="menu-heading fw-bold text-uppercase fs-7">{{ $kop }}</span>
                    </div>
                    <!--end:Menu content-->
                </div>
                <!--end:Menu item-->
                @foreach ($menu as $row)
                    @php $routeMenu = Str::snake($row['name']) @endphp

                    @if ($row['option'] === '__YES__')
                        <!--begin:Menu item-->
                        <div data-kt-menu-trigger="click"
                            class="menu-item menu-accordion {{ request()->routeIs("$kop.$routeMenu.*") ? 'here show' : '' }}">
                            <!--begin:Menu link-->
                            <span class="menu-link">
                                <span class="menu-icon">{!! getIcon('abstract-26', 'fs-2') !!}</span>
                                <span class="menu-title"> {{ $row['name'] }} </span>
                                <span class="menu-arrow"></span>
                            </span>
                            <!--end:Menu link-->
                            <!--begin:Menu sub-->
                            <div class="menu-sub menu-sub-accordion">
                                @foreach ($row['menu_subs'] as $menuSub)
                                    @php $routeMenuSub = Str::snake($menuSub['name']); @endphp
                                    <!--begin:Menu item-->
                                    <div class="menu-item">
                                        <!--begin:Menu link-->
                                        <a class="menu-link {{ request()->routeIs("$kop.$routeMenu.$routeMenuSub.*") ? 'active' : '' }}"
                                            href="{{ Route::has("$kop.$routeMenu.$routeMenuSub") ? route("$kop.$routeMenu.$routeMenuSub") : route('error') }}"
                                            wire:navigate>
                                            <span class="menu-bullet">
                                                <span class="bullet bullet-dot"></span>
                                            </span>
                                            <span class="menu-title"> {{ $menuSub['name'] }} </span>
                                        </a>
                                        <!--end:Menu link-->
                                    </div>
                                    <!--end:Menu item-->
                                @endforeach
                            </div>
                            <!--end:Menu sub-->
                        </div>
                        <!--end:Menu item-->
                    @else
                        <div class="menu-item menu-accordion">
                            <!--begin:Menu link-->
                            <span class="menu-link">
                                <span class="menu-icon">{!! getIcon('abstract-26', 'fs-2') !!}</span>
                                <span class="menu-title"> {{ $row['name'] }} </span>
                                {{-- <span class="menu-arrow"></span> --}}
                            </span>
                            <!--end:Menu link-->
                        </div>
                    @endif
                @endforeach
            @endforeach




            @include(config('settings.KT_THEME_LAYOUT_DIR') . '/partials/sidebar-layout/sidebar/__documentation')

        </div>
        <!--end::Menu-->
    </div>
    <!--end::Menu wrapper-->
</div>
<!--end::sidebar menu-->
