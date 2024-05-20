<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>@yield('title')</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link type="text/css" rel="icon" href="{{ URL::asset('/3azmkheader.jpg') }}" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('plugins/fontawesome-free/css/all.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('styles/toastr.css') }}">
    <!-- Ionicons -->
    <link rel="stylesheet" href="{{ asset('https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css') }}">
    <!-- Tempusdominus Bbootstrap 4 -->
    <link rel="stylesheet"
        href="{{ asset('plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') }}">
    <!--edit font-->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@300;400;600&display=swap" rel="stylesheet">
    <!-- iCheck -->
    <link rel="stylesheet" href="{{ asset('plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
    <!-- JQVMap -->
    <link rel="stylesheet" href="{{ asset('plugins/jqvmap/jqvmap.min.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('dist/css/adminlte.min.css') }}">
    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="{{ asset('plugins/overlayScrollbars/css/OverlayScrollbars.min.css') }}">
    <!-- Daterange picker -->
    <link rel="stylesheet" href="{{ asset('plugins/daterangepicker/daterangepicker.css') }}">
    <!-- summernote -->
    <link rel="stylesheet" href="{{ asset('plugins/summernote/summernote-bs4.css') }}">
    <!-- Google Font: Source Sans Pro -->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
    @if (app()->getLocale() == 'ar')
        <!-- Bootstrap 4 RTL -->
        <link rel="stylesheet" href="{{ asset('dist/css/bootstrap_rtl.min.css') }}">
        <!-- Custom style for RTL -->
        <link rel="stylesheet" href="{{ asset('dist/css/custom.css') }}">
    @endif

    <link rel="stylesheet" href="{{ asset('dist/css/global.css') }}">
    @if (app()->getLocale() == 'en')
        <link rel="stylesheet" href="{{ asset('dist/css/style_ltr.css') }}">
    @endif
    @yield('style')
    @stack('styles')
</head>

<body class="hold-transition sidebar-mini layout-fixed" dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}">
    <div class="wrapper">

        @include('admin.lteLayout.header')

        @include('admin.lteLayout.sidebar')

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">

            @yield('content')
        </div>
        <!-- /.content-wrapper -->
        <!--<footer class="main-footer">-->
        <!--    <strong>@lang('messages.copyRight')-->
        <!--        <a href="https://tqnee.com.sa"> @lang('messages.tqneeCompany') </a>-->
        <!--        &copy; {{ \Carbon\Carbon::now()->format('Y') }}-->
        <!--        .</strong>-->
        <!--    @lang('messages.all_rights_reserved').-->
        <!--    <div class="float-right d-none d-sm-inline-block">-->

        <!--    </div>-->
        <!--</footer>-->
        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
        </aside>
        <div id="sidebar-overlay"></div>
        <!-- /.control-sidebar -->
    </div>

    <!-- ./wrapper -->
    <div class="modal fade" id="restaurantSearchModal" tabindex="-1" role="dialog"
        aria-labelledby="restaurantSearchModalTitle" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="restaurantSearchModalTitle">{{ trans('dashboard.search') }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="" method="post" id="global-search-form">
                        @csrf
                        <div class="form-group search">
                            <input type="text" class="form-control" name="search" id="global-search-input"
                                placeholder="{{ trans('dashboard.search') }}">
                            <i class="fa fa-search"></i>
                        </div>
                        <div class="form-group text-center ">

                            <label for="" class="title">
                                <input type="radio" name="type" value="restaurant" id="type-restaurant" checked>
                                <label for="type-restaurant">{{ trans('dashboard.restaurants') }}</label>
                            </label>

                            <label for="" class="title">
                                <input type="radio" name="type" value="branch" id="type-branch">
                                <label for="type-branch">{{ trans('dashboard.branch') }}</label>
                            </label>

                        </div>
                        <div class="search-results">

                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
    <!-- jQuery -->
    <script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
    <!-- jQuery UI 1.11.4 -->
    <script src="{{ asset('plugins/jquery-ui/jquery-ui.min.js') }}"></script>
    <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
    <script>
        $.widget.bridge('uibutton', $.ui.button)
    </script>
    @if (app()->getLocale() == 'ar')
        <!-- Bootstrap 4 rtl -->
        <script src="{{ asset('dist/js/bootstrap_rtl.min.js') }}"></script>
    @endif
    <script type="text/javascript" src="{{ asset('scripts/toastr.min.js') }}"></script>
    <!-- Bootstrap 4 -->
    <script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <!-- ChartJS -->
    <script src="{{ asset('plugins/chart.js/Chart.min.js') }}"></script>
    <!-- Sparkline -->
    <script src="{{ asset('plugins/sparklines/sparkline.js') }}"></script>
    <!-- JQVMap -->
    <script src="{{ asset('plugins/jqvmap/jquery.vmap.min.js') }}"></script>
    <script src="{{ asset('plugins/jqvmap/maps/jquery.vmap.world.js') }}"></script>
    <!-- jQuery Knob Chart -->
    <script src="{{ asset('plugins/jquery-knob/jquery.knob.min.js') }}"></script>
    <!-- daterangepicker -->
    <script src="{{ asset('plugins/moment/moment.min.js') }}"></script>
    <script src="{{ asset('plugins/daterangepicker/daterangepicker.js') }}"></script>
    <!-- Tempusdominus Bootstrap 4 -->
    <script src="{{ asset('plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') }}"></script>
    <!-- Summernote -->
    <script src="{{ asset('plugins/summernote/summernote-bs4.min.js') }}"></script>
    <!-- overlayScrollbars -->
    <script src="{{ asset('plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js') }}"></script>
    <!-- AdminLTE App -->
    <script src="{{ asset('dist/js/adminlte.js') }}"></script>
    <!-- AdminLTE dashboard demo (This is only for demo purposes) -->
    <script src="{{ asset('dist/js/pages/dashboard.js') }}"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="{{ asset('dist/js/demo.js') }}"></script>
    <script>
        $('.custom-switch.off .text').html('Off');
        var intervalSidebar = null;
        toastr.options = {
            "closeButton": false,
            "debug": false,
            "newestOnTop": false,
            "progressBar": true,
            "positionClass": "toast-top-right",
            "preventDuplicates": false,
            "onclick": null,
            "showDuration": "300",
            "hideDuration": "1000",
            "timeOut": "5000",
            "extendedTimeOut": "1000",
            "showEasing": "swing",
            "hideEasing": "linear",
            "showMethod": "fadeIn",
            "hideMethod": "fadeOut"
        };
        var countSidebarLoop = 0;
        var searchTimeOut = null;
        var oldSearchValue = null;
        var oldTypeValue = null;

        $(function() {

            intervalSidebar = setInterval(() => {
                if ($('.os-viewport').length && $(".main-sidebar .nav-link.active").length) {
                    $('.os-viewport').animate({
                        scrollTop: eval($(".main-sidebar .nav-link.active").offset().top - 140)
                    }, 500);
                    clearInterval(intervalSidebar);

                } else if (countSidebarLoop >= 120) {
                    clearInterval(intervalSidebar);

                }

                countSidebarLoop += 1;
            }, 1000);
            $('#btn-sidebar-menu').on('click', function() {

                var tag = $('body.sidebar-mini');
                console.log(tag);
                if (tag.hasClass('sidebar-open')) {
                    tag.removeClass('sidebar-open').addClass('sidebar-collapse');
                    // $('#sidebar-overlay').css('display' , 'none');
                } else if (tag.hasClass('sidebar-collapse')) {
                    tag.removeClass('sidebar-collapse').addClass('sidebar-open');
                    // console.log(tag);
                    // $('#sidebar-overlay').css('display' , 'block');
                } else {
                    if (window.innerWidth > 800)
                        tag.addClass('sidebar-collapse').removeClass('sidebar-open');
                    else tag.addClass('sidebar-open').removeClass('sidebar-collapse');
                    // console.log(window.innerWidth);
                    // $('#sidebar-overlay').css('display' , 'block');
                }
            });
            $('#sidebar-overlay').on('click', function() {
                console.log('test');
                $('body.sidebar-mini').removeClass('sidebar-open').addClass('sidebar-collapse');
            });
            $('.custom-switch').on('click', function() {
                var tag = $(this);
                if (tag.hasClass('off')) {
                    window.location.replace(tag.data('url_off'));
                    tag.removeClass('off');
                } else {
                    window.location.replace(tag.data('url_on'));
                    tag.addClass('off');
                }
            });
            $('#global-search-form').submit(function() {
                return false
            });

            $('#restaurantSearchModal input[name=type]').on('click', function() {
                globalSearch();
            });
            $('#restaurantSearchModal input[name=search]').on('keyup', function() {
                globalSearch();
            });
            $('a[data-target="#restaurantSearchModal"]').on('click', function() {
                console.log('search click');
                setTimeout(() => {
                    $('#global-search-input').focus();
                }, 900);
            });
            $(document).keydown(function(event) {
                // Check for custom keyboard shortcut: Ctrl + Shift + K

                if (event.shiftKey && event.which === 82) {
                    if (!$('#restaurantSearchModal').is(':visible')) {
                        $('#restaurantSearchModal').modal('show');
                        setTimeout(() => {
                            $('#global-search-input').focus();
                        }, 900);
                    } else {
                        $('#restaurantSearchModal').modal('hide');
                    }
                }
            });
        });
    </script>
    @yield('scripts')
    @stack('scripts')
</body>

</html>
<style>
    .content-wrapper {
        font-family: 'cairo' !important;
    }

    .content {
        font-family: 'cairo' !important;
    }

    /*icon of detlet content at table*/
    .delete_city i,
    .delete_data i {
        color: white;
    }

    /*.content h3 a {*/
    /*background-color:#64748b !important;*/
    /*width:max-content;*/
    /*border-radius:5px;*/
    /*color:white !important;*/
    /*}*/
    /*addtion table*/

    .table-striped tbody tr:nth-of-type(odd) {
        background-color: white !important;

    }

    .table-striped>tbody>tr:nth-of-type(odd) {
        --bs-table-accent-bg: white !important;
        color: var(--bs-table-striped-color);
    }

    .table>:not(:last-child)>:last-child>* {
        border-bottom-color: transparent !important;
    }

    .table {
        border-top: red !important;
    }

    /*end addtion table*/
    /*.content.row h3{*/
    /*     background-color:#64748b;*/
    /*     width:max-content;*/
    /*     border-radius:5px;*/
    /* }*/
    /*.content h3 a {*/
    /*             color:white !important;*/
    /* }*/
    .card i {
        color: white;
    }
</style>
