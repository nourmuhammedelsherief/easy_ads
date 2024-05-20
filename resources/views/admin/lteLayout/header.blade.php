<!-- Navbar -->
<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link " id="btn-sidebar-menu" data-widget="pushmenux" href="#"><i class="fas fa-bars"></i></a>
        </li>
        <!--add here welcome username-->
        <li class="nav-item">
            <a class="nav-link welcome " href="#">
                مرحبا
                <?php if (Auth::guard('admin')->check()) {
                    echo Auth::guard('admin')->user()->name;
                } ?>
            </a>

        </li>
        <!-- end  welcome username-->

        <!--<li class="nav-item d-none d-sm-inline-block">-->
        <!--    <a href="{{ url('/admin/home') }}" class="nav-link">@lang('messages.control_panel')</a>-->
        <!--</li>-->
        {{--        <li class="nav-item d-none d-sm-inline-block"> --}}
        {{--            <a href="#" class="nav-link">Contact</a> --}}
        {{--        </li> --}}
        <!--here i delelet lang-->


    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav mr-auto-navbav">
        <li class="nav-item">
            <a class="nav-link logout" href="javscript:;" data-toggle="modal" data-target="#restaurantSearchModal">
                <i class="fas fa-search"></i>
                <span class="badge badge-warning navbar-badge"></span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link logout" data-toggle="dropdown" href="#">

                <i class="fas fa-user"></i>

                <span class="badge badge-warning navbar-badge"></span>
            </a>

            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                {{--                <span class="dropdown-item dropdown-header"> @lang('messages.profile') </span> --}}
                {{--                <div class="dropdown-divider"></div> --}}
                {{--                <a href="{{url('/admin/profile')}}" class="dropdown-item"> --}}
                {{--                    <i class="fas fa-user"></i> --}}
                {{--                    @lang('messages.profile') --}}
                {{--                </a> --}}
                {{--                <div class="dropdown-divider"></div> --}}
                {{--                <a href="{{url('/admin/profileChangePass')}}" class="dropdown-item"> --}}
                {{--                    <i class="fas fa-user"></i> --}}
                {{--                    @lang('messages.changPassword') --}}
                {{--                </a> --}}
                <div class="dropdown-divider"></div>
                <a onclick="document.getElementById('logout_form').submit()" class="dropdown-item">
                    <i class="fa fa-arrow-left"></i>
                    @lang('messages.logout')
                </a>
            </div>
        </li>
        <!--move_lang-->
        <li class="nav-item d-none d-sm-inline-block">
            {{--            <a href="#" class="nav-link">Lang</a> --}}
            @if (app()->getLocale() == 'en')
                <a href="{{ url('locale/ar') }}" class="nav-link">
                    <span class="username username-hide-on-mobile">
                        عربى
                    </span>
                </a>
            @else
                <a href="{{ url('locale/en') }}" class="nav-link">
                    <span class="username username-hide-on-mobile">
                        English
                    </span>
                </a>
            @endif
        </li>

        <!--end_move_lang-->
        {{--        <li class="nav-item"> --}}
        {{--            <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#"> --}}
        {{--                <i class="fas fa-th-large"></i> --}}
        {{--            </a> --}}
        {{--        </li> --}}
    </ul>
    <form style="display: none;" id="logout_form" action="{{ route('admin.logout') }}" method="post">
        {!! csrf_field() !!}
    </form>
</nav>
<!-- /.navbar -->
<style>
    .logout {
        background-color: #eeeeee;
        border-radius: 50%;
        color: black;
    }

    .welcome {
        font-size: 18px;
        text-align: center;
        font-family: 'Cairo', sans-serif;
        font-weight: 500;
        color: #616161 !important;
        /*background-color:red;*/
        margin-top: -3px;



    }
</style>
