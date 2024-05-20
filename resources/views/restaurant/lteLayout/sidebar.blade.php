<style>
    .sidebar-title p,
    .sidebar-title a,
    .sidebar-title span {
        color: black !important;
        font-family: 'cairo' !important;
    }

    .sidebar-title * {
        color: black !important;
    }

    .main-sidebar {
        background-color: #fff !important;
    }

    .user-panel {
        border-bottom: none !important;
    }

    .nav-link.active,
    .show > .nav-link {
        color: #960082 !important;
        background-color: transparent !important;

    }

    .nav-pills .nav-link:not(.active):hover {
        color: #960082 !important;
    }

    .nav-pills .nav-link,
    .brand-text {
        color: #252525;
        font-weight: 600;
        font-size: 1rem;
        font-family: 'cairo' !important;
    }

    .sidebar-title {
        border-top: none !important;
    }

    .nav-item {
        border-bottom: 1px solid #dfdfdf;
    }
</style>
@php
    $user = Auth::guard('restaurant')->user();
    $subscription = $user->ads_subscription;
@endphp
<!-- Main Sidebar Container -->
<aside class="main-sidebar elevation-4">
    <!-- Brand Logo -->
    <a href="{{ route('restaurant.home') }}" class="brand-link">
        @if($user->az_logo)
            <img src="{{asset('/uploads/restaurants/logo/' . $user->az_logo)}}" alt="AdminLTE Logo" class="brand-image"
                 style="opacity: .8">
        @else
            <img src="{{asset('/3azmkheader.jpg')}}" alt="AdminLTE Logo" class="brand-image"
                 style="opacity: .8">
        @endif
        <span class="brand-text font-weight-light"> @lang('messages.control_panel') </span>
    </a>
    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                data-accordion="false">
                <li class="nav-item">
                    <a href="{{ route('restaurant.home') }}" class="nav-link">
                        <i class="nav-icon fa fa-home"></i>
                        <p>
                            @lang('messages.home')
                        </p>
                    </a>
                </li>
                @if($subscription and ($subscription->status == 'free' or $subscription->status == 'active'))
                    <li class="nav-item sidebar-title">
                        <i class="nav-icon far fa-user"></i>
                        <p class="">{{ trans('messages.account_settings') }}</p>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('RestaurantProfile') }}"
                           class="nav-link {{ strpos(URL::current(), '/console/profile') !== false ? 'active' : '' }}">
                            <i class="nav-icon far fa-user"></i>
                            <p>
                                @lang('messages.profile')
                            </p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('integrations') }}"
                           class="nav-link {{ strpos(URL::current(), '/console/integrations') !== false ? 'active' : '' }}">
                            <i class="nav-icon fa fa-download"></i>
                            <p>
                                @lang('messages.pullMenu')
                            </p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ url('/console/barcode') }}"
                           class="nav-link {{ strpos(URL::current(), '/console/barcode') !== false ? 'active' : '' }}">
                            <i class="nav-icon fa fa-barcode"></i>
                            <p>
                                @lang('messages.barcode')
                            </p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('branches.index') }}"
                           class="nav-link {{ strpos(URL::current(), '/console/branches') !== false ? 'active' : '' }}">
                            <i class="nav-icon far fa-flag"></i>
                            <span class="badge badge-info right">
                                {{ \App\Models\Restaurant\Azmak\AZBranch::whereRestaurantId($user->type == 'employee' ? $user->restaurant_id : $user->id)->count() }}
                            </span>
                            <p>
                                @lang('messages.branches')
                            </p>
                        </a>
                    </li>
                    <li class="nav-item sidebar-title">
                        <i class="nav-icon fa fa-bars"></i>
                        <p class="">{{ trans('messages.side_3') }}</p>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('menu_categories.index') }}"
                           class="nav-link {{ strpos(URL::current(), '/console/menu_categories') !== false ? 'active' : '' }}">
                            <i class="nav-icon fa fa-bars"></i>
                            <span class="badge badge-info right">
                                {{ \App\Models\Restaurant\Azmak\AZMenuCategory::whereRestaurantId($user->type == 'employee' ? $user->restaurant_id : $user->id)->count() }}
                            </span>
                            <p>
                                @lang('messages.menu_categories')
                            </p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('modifiers.index') }}"
                           class="nav-link {{ strpos(URL::current(), '/console/modifiers') !== false ? 'active' : '' }}">
                            <i class="nav-icon fa fa-plus"></i>
                            <span class="badge badge-info right">
                                {{ \App\Models\Restaurant\Azmak\AZModifier::whereRestaurantId($user->type == 'employee' ? $user->restaurant_id : $user->id)->count() }}
                            </span>
                            <p>
                                @lang('messages.modifiers')
                            </p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('additions.index') }}"
                           class="nav-link {{ strpos(URL::current(), '/console/additions') !== false ? 'active' : '' }}">
                            <i class="nav-icon fa fa-plus"></i>
                            <span class="badge badge-info right">
                                {{ \App\Models\Restaurant\Azmak\AZOption::whereRestaurantId($user->type == 'employee' ? $user->restaurant_id : $user->id)->count() }}
                            </span>
                            <p>
                                @lang('messages.options')
                            </p>
                        </a>
                    </li>
{{--                    <li class="nav-item">--}}
{{--                        <a href="{{ route('posters.index') }}"--}}
{{--                           class="nav-link {{ strpos(URL::current(), '/console/posters') !== false ? 'active' : '' }}">--}}
{{--                            <i class="nav-icon fa fa-image"></i>--}}
{{--                            <span class="badge badge-info right">--}}
{{--                                {{ \App\Models\AZRestaurantPoster::whereRestaurantId($user->type == 'employee' ? $user->restaurant_id : $user->id)->count() }}--}}
{{--                            </span>--}}
{{--                            <p>--}}
{{--                                @lang('messages.posters')--}}
{{--                            </p>--}}
{{--                        </a>--}}
{{--                    </li>--}}
{{--                    <li class="nav-item">--}}
{{--                        <a href="{{ url('/console/sensitivities') }}"--}}
{{--                           class="nav-link {{ strpos(URL::current(), '/console/sensitivities') !== false ? 'active' : '' }}">--}}
{{--                            <i class="nav-icon fa fa-image"></i>--}}
{{--                            <span class="badge badge-info right">--}}
{{--                                {{ \App\Models\AZRestaurantSensitivity::whereRestaurantId($user->type == 'employee' ? $user->restaurant_id : $user->id)->count() }}--}}
{{--                            </span>--}}
{{--                            <p>--}}
{{--                                @lang('messages.sensitivities')--}}
{{--                            </p>--}}
{{--                        </a>--}}
{{--                    </li>--}}
{{--                    <li class="nav-item">--}}
{{--                        <a href="{{ route('products.index') }}"--}}
{{--                           class="nav-link {{ strpos(URL::current(), '/console/products') !== false ? 'active' : '' }}">--}}
{{--                            <i class="nav-icon fa fa-list"></i>--}}
{{--                            <span class="badge badge-info right">--}}
{{--                                {{ \App\Models\Restaurant\Azmak\AZProduct::whereRestaurantId($user->type == 'employee' ? $user->restaurant_id : $user->id)->count() }}--}}
{{--                            </span>--}}
{{--                            <p>--}}
{{--                                @lang('messages.products')--}}
{{--                            </p>--}}
{{--                        </a>--}}
{{--                    </li>--}}
                    <li class="nav-item sidebar-title">
                        <i class="nav-icon fa fa-users"></i>
                        <p class="">{{ trans('messages.side_4') }}</p>
                    </li>
{{--                    <li--}}
{{--                        class="nav-item {{ strpos(URL::current(), '/console/sliders') !== false ? 'active' : '' }}">--}}
{{--                        <a href="{{ url('/console/sliders') }}"--}}
{{--                           class="nav-link {{ (strpos(URL::current(), '/console/sliders') ) !== false ? 'active' : '' }}">--}}
{{--                            <i class="fas fa-sliders-h"></i>--}}
{{--                            <p>--}}
{{--                                @lang('messages.sliders')--}}
{{--                            </p>--}}
{{--                        </a>--}}
{{--                    </li>--}}
                    <li
                        class="nav-item {{ strpos(URL::current(), '/console/az_contacts') !== false ? 'active' : '' }}">
                        <a href="{{ url('/console/az_contacts') }}"
                           class="nav-link {{ (strpos(URL::current(), '/console/az_contacts')) !== false ? 'active' : '' }}">
                            <i class="fas fa-file"></i>
                            <p>
                                @lang('messages.contact_us')
                            </p>
                        </a>
                    </li>
                    <li
                        class="nav-item {{ strpos(URL::current(), '/console/terms/conditions') !== false ? 'active' : '' }}">
                        <a href="{{ url('/console/terms/conditions') }}"
                           class="nav-link {{ (strpos(URL::current(), '/console/terms/conditions')) !== false ? 'active' : '' }}">
                            <i class="fas fa-file"></i>
                            <p>
                                @lang('messages.terms_conditions')
                            </p>
                        </a>
                    </li>
                    <li
                        class="nav-item {{ strpos(URL::current(), '/console/azmak_about') !== false ? 'active' : '' }}">
                        <a href="{{ url('/console/azmak_about') }}"
                           class="nav-link {{ (strpos(URL::current(), '/console/azmak_about')) !== false ? 'active' : '' }}">
                            <i class="fas fa-file"></i>
                            <p>
                                @lang('messages.about_app')
                            </p>
                        </a>
                    </li>
                @endif
            </ul>
        </nav>
        <!-- Sidebar Menu -->

        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
