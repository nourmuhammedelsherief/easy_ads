<!-- Navbar -->
<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link " id="btn-sidebar-menu" data-widget="pushmenux" href="#"><i class="fas fa-bars"></i></a>
        </li>
        <li class="welcome_res">
            <span> @lang('messages.welcome') ,</span>
            <span>
                @if(app()->getLocale() == 'ar')
                    <?php if (Auth::guard('restaurant')->check()) {
                        echo Auth::guard('restaurant')->user()->name_ar;
                    } ?>
                @else
                    <?php if (Auth::guard('restaurant')->check()) {
                        echo Auth::guard('restaurant')->user()->name_en;
                    } ?>
                @endif
            </span>
        </li>


    </ul>

    <!-- SEARCH FORM -->
{{-- <form class="form-inline ml-3">
    <div class="input-group input-group-sm">
        <input class="form-control form-control-navbar" type="search" placeholder="Search" aria-label="Search">
        <div class="input-group-append">
            <button class="btn btn-navbar" type="submit">
                <i class="fas fa-search"></i>
            </button>
        </div>
    </div>
</form> --}}

<!-- Right navbar links -->
    <ul class="navbar-nav mr-auto-navbav">
        <li class="nav-item link_icon">
            <?php
            $restaurant = Auth::guard('restaurant')->user();
            if ($restaurant and $restaurant->type == 'employee'):
                $restaurant = \App\Models\Restaurant::find($restaurant->restaurant_id);
            endif;
            $name = $restaurant->name_barcode == null ? $restaurant->name_en : $restaurant->name_barcode
            ?>
            <a class="nav-link" target="_blank" href="{{url('/shop/' .  $name)}}">
                <i class="fa fa-home"></i>
                <span class="hidemob">
                    @lang('messages.show_menu')
                </span>
            </a>
        </li>
        @php
            $setting = \App\Models\Setting::first();
        @endphp
        <li class="nav-item link_icon">
            <a target="_blank" class="nav-link"
               href="https://api.whatsapp.com/send?phone={{$setting->technical_support_number}}" style="color: green">
                <i class="fab fa-whatsapp" style="color:green"></i>
                <span class="hidemob">
                    @lang('messages.contact_technical_support')
                </span>
            </a>
        </li>
        <li class="nav-item link_icon ">
            <a target="_blank" class="nav-link "
               href="https://api.whatsapp.com/send?phone={{$setting->customer_services_number}}" style="color: green">
                <i class="fab fa-whatsapp" style="color:green"></i>
                <span class="hidemob">
                    @lang('messages.contact_customer_services')
                </span>
            </a>
        </li>
        <li class="nav-item link_icon">
            <a class="nav-link" data-toggle="dropdown" href="#">
                <i class="fas fa-user"></i>

                <span class="badge badge-warning navbar-badge"></span>
            </a>
            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">


                <a onclick="document.getElementById('logout_form').submit()" class="dropdown-item">
                    <i class="fas fa-key"></i>
                    @lang('messages.logout')
                </a>
            </div>
        </li>
        <!--lang-->
        <li class="nav-item d-none d-sm-inline-block lang ">
            {{--            <a href="#" class="nav-link">Lang</a>--}}
            @if(\Illuminate\Support\Facades\Auth::guard('restaurant')->user()->ar == 'true' && \Illuminate\Support\Facades\Auth::guard('restaurant')->user()->en == 'true')
                @if(app()->getLocale() == 'en')
                    <a href="{{ url('console/locale/ar')  }}" class="nav-link">
                    <span class="username username-hide-on-mobile">
                        <i class="fa fa-language"></i>
                        عربى
                    </span>
                    </a>

                @else
                    <a href="{{  url('console/locale/en') }}" class="nav-link">
                    <span class="username username-hide-on-mobile">
                        <i class="fa fa-language"></i>
                        English
                    </span>
                    </a>
                @endif
            @endif
        </li>
        {{--        <li class="nav-item">--}}
        {{--            <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#">--}}
        {{--                <i class="fas fa-th-large"></i>--}}
        {{--            </a>--}}
        {{--        </li>--}}
    </ul>
    <form style="display: none;" id="logout_form" action="{{ route('restaurant.logout') }}" method="post">
        {!! csrf_field() !!}
    </form>
</nav>
<!-- /.navbar -->
<style>
    .main-header {
        display: flex;
        flex-direction: row;
        flex-wrap: wrap;
        align-items: center;
        row-gap: 10px;
        font-family: 'cairo' !important;
        /*justify-content: center;*/
    }

    .welcome_res {
        /*background-color:red;*/
        margin-top: 7px;
    }

    .link_icon {
        background-color: #eeeeee;
        border-radius: 50%;
        position: relative;
        margin: 0 7px !important;
    }

    .hidemob {
        display: none;
        position: absolute;
        left: 0;

    }

    .link_icon:hover .hidemob {
        display: block;
    }
</style>
