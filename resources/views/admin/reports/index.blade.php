@extends('admin.lteLayout.master')

@section('title')
    @lang('messages.reports')
@endsection

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">@lang('messages.reports')</h1>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <form role="form" action="{{route('reports.index')}}" method="get" enctype="multipart/form-data">
                    <input type='hidden' name='_token' value='{{Session::token()}}'>

                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label class="control-label"> @lang('messages.month') </label>
                                    <select name="month" class="form-control" required>
                                        @for($i = 1; $i <= 12 ; $i++)
                                            <option value="{{$i}}" {{$i == $month ? 'selected' : ''}}> {{$i}} </option>
                                        @endfor
                                    </select>
                                    @if ($errors->has('month'))
                                        <span class="help-block">
                                            <strong style="color: red;">{{ $errors->first('month') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label class="control-label"> @lang('messages.year') </label>
                                    <select name="year" class="form-control" required>
                                        @for($i = 2022; $i <= \Carbon\Carbon::now()->format('Y') ; $i++)
                                            <option value="{{$i}}" {{$i == $year ? 'selected' : ''}}> {{$i}} </option>
                                        @endfor
                                    </select>
                                    @if ($errors->has('year'))
                                        <span class="help-block">
                                            <strong style="color: red;">{{ $errors->first('year') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-sm-2">
                                <br>
                                <button type="submit" class="btn btn-primary">@lang('messages.show')</button>
                            </div>
                        </div>
                    </div>

                </form>
            </div>
            <h3 class="text-center"> @lang('messages.show_restaurants_reports') {{$month}}/{{$year}} </h3>
            <br>
            {{--            @if(auth()->guard('admin')->user()->role == 'admin')--}}
            {{--                <div class="row">--}}
            {{--                    <div class="col-lg-1"></div>--}}
            {{--                    <div class="col-lg-5 col-5">--}}
            {{--                        <!-- small box -->--}}
            {{--                        <div class="small-box bg-danger">--}}
            {{--                            <div class="inner">--}}
            {{--                                <h3>--}}
            {{--                                    {{number_format((float)($month_total_amount - $month_total_taxes), 0, '.', '')}} @lang('messages.SR')--}}
            {{--                                </h3>--}}

            {{--                                <p>--}}
            {{--                                    @lang('messages.month_total_amount')--}}
            {{--                                </p>--}}
            {{--                            </div>--}}
            {{--                            <div class="icon">--}}
            {{--                                <i class="ion ion-person-add"></i>--}}
            {{--                            </div>--}}
            {{--                            <a href="{{url('/admin/histories')}}" class="small-box-footer">@lang('messages.details')--}}
            {{--                                <i class="fas fa-arrow-circle-right"></i></a>--}}
            {{--                        </div>--}}
            {{--                    </div>--}}
            {{--                    <div class="col-lg-5 col-5">--}}
            {{--                        <!-- small box -->--}}
            {{--                        <div class="small-box bg-green">--}}
            {{--                            <div class="inner">--}}
            {{--                                <h3>--}}
            {{--                                    {{number_format((float)$month_total_taxes, 0, '.', '')}} @lang('messages.SR')--}}
            {{--                                </h3>--}}

            {{--                                <p>@lang('messages.month_total_taxes')</p>--}}
            {{--                            </div>--}}
            {{--                            <div class="icon">--}}
            {{--                                <i class="nav-icon fa fa-history"></i>--}}
            {{--                            </div>--}}
            {{--                            <a href="{{url('/admin/histories')}}" class="small-box-footer">@lang('messages.details') <i--}}
            {{--                                        class="fas fa-arrow-circle-right"></i></a>--}}
            {{--                        </div>--}}
            {{--                    </div>--}}
            {{--                    <div class="col-lg-1"></div>--}}
            {{--                </div>--}}
            {{--            @endif--}}
            <hr>
            <h4 class="text-center" style="color: red">
                @lang('messages.restaurants')
            </h4>
            <br>
            <div class="row">
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <a href="{{route('reports.restaurants' , [$year , $month , 'new'])}}"
                    >
                        <div class="small-box">
                            <div class="inner">
                                <p>
                                    @lang('messages.not_paid')
                                </p>
                                <h3 class="text-center">
                                    {{$new_not_paid}}
                                </h3>

                            </div>

                        </div>
                    </a>

                </div>
                <div class="col-lg-3 col-6">
                    <a href="{{route('reports.restaurants' , [$year , $month , 'active'])}}"
                    >
                        <!-- small box -->
                        <div class="small-box">
                            <div class="inner">

                                <p>
                                    @lang('messages.subscribed_restaurants')
                                </p>
                                <h3 class="text-center">
                                    {{$subscribed_restaurants}}
                                </h3>
                            </div>

                        </div>
                    </a>

                </div>
                <div class="col-lg-6 col-6">
                    <!-- small box -->
                    <div class="small-box">
                        <div class="inner">
                            <p>@lang('messages.subscribed_restaurants_amount')</p>

                            <h3 class="text-center">
                                {{number_format((float)$subscribed_restaurants_amount, 0, '.', '')}} @lang('messages.SR')
                            </h3>
                        </div>

                        <form role="form" action="{{route('admin.month_histories')}}" method="get"
                              enctype="multipart/form-data">
                            <input type='hidden' name='_token' value='{{Session::token()}}'>
                            <input type="hidden" name="year" value="{{$year}}">
                            <input type="hidden" name="month" value="{{$month}}">
                            <input type="hidden" name="type" value="restaurant">
                            <input type="hidden" name="status" value="subscribed">
                            <button type="submit" style="width: 100% ; background: rgba(0,0,0,.1); border: none">
                                @lang('messages.details')
                                <i class="fas fa-arrow-circle-right"></i>
                            </button>
                        </form>
                    </div>
                </div>
                <hr>
                <div class="col-lg-3 col-6">
                    <a href="{{route('reports.restaurants' , [$year , $month , 'free'])}}"
                    >
                        <!-- small box -->
                        <div class="small-box">
                            <div class="inner">
                                <p>
                                    @lang('messages.free_restaurants')
                                </p>
                                <h3 class="text-center">
                                    {{$free}}
                                </h3>
                            </div>


                        </div>
                    </a>

                </div>
                <div class="col-lg-3 col-6">
                    <a href="{{route('reports.restaurants' , [$year , $month , 'renew'])}}"
                    >
                        <!-- small box -->
                        <div class="small-box">
                            <div class="inner">
                                <p>
                                    @lang('messages.renewed_restaurants')
                                </p>
                                <h3 class="text-center">
                                    {{$renewed_restaurants}}
                                </h3>
                            </div>
                        </div>
                    </a>

                </div>
                <div class="col-lg-6 col-6">
                    <!-- small box -->
                    <div class="small-box">
                        <div class="inner">
                            <p>@lang('messages.renewed_amount')</p>

                            <h3 class="text-center">
                                {{number_format((float)$renewed_restaurants_amount, 0, '.', '')}} @lang('messages.SR')
                            </h3>
                        </div>

                        <form role="form" action="{{route('admin.month_histories')}}" method="get"
                              enctype="multipart/form-data">
                            <input type='hidden' name='_token' value='{{Session::token()}}'>
                            <input type="hidden" name="year" value="{{$year}}">
                            <input type="hidden" name="month" value="{{$month}}">
                            <input type="hidden" name="type" value="restaurant">
                            <input type="hidden" name="status" value="subscribed">
                            <button type="submit" style="width: 100% ; background: rgba(0,0,0,.1); border: none">
                                @lang('messages.details')
                                <i class="fas fa-arrow-circle-right"></i>
                            </button>
                        </form>
                    </div>
                </div>

            </div>
            <!--end row of restaurants-->
            <hr>
            <h4 class="text-center" style="color: red">
                @lang('messages.commissions')
            </h4>
            <br>
            <div class="row">
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <a href="{{route('commission_report.restaurants' , [$year , $month])}}"
                    >
                        <div class="small-box">
                            <div class="inner">
                                <p>
                                    @lang('messages.commissions_payable')
                                </p>
                                <h4 class="text-center">
                                    {{$orders_commissions - $restaurant_commissions}}
                                    @lang('messages.SR')
                                </h4>

                            </div>

                        </div>
                    </a>

                </div>
                <div class="col-lg-3 col-6">
                    <a href="{{route('reports.orders' , [$year , $month])}}"
                    >
                        <!-- small box -->
                        <div class="small-box">
                            <div class="inner">
                                <p>
                                    @lang('messages.restaurant_az_orders_count')
                                </p>
                                <h3 class="text-center">
                                    {{App\Models\Restaurant\Azmak\AZOrder::where('status' , '!=' , 'new')->whereyear('created_at','=',$year)->whereMonth('created_at','=',$month)->count()}}
                                </h3>
                            </div>
                        </div>
                    </a>

                </div>
                <div class="col-lg-6 col-6">
                    <!-- small box -->
                    <a href="{{route('reports.orders' , [$year , $month])}}">
                        <div class="small-box">
                            <div class="inner">
                                <p>@lang('messages.orders_commissions')</p>

                                <h3 class="text-center">
                                    {{number_format((float)$orders_commissions, 0, '.', '')}} @lang('messages.SR')
                                </h3>
                            </div>
                        </div>
                    </a>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-6 col-6">
                    <a href="{{route('reports.commissions' , [$year , $month])}}">
                        <!-- small box -->
                        <div class="small-box">
                            <div class="inner">

                                <p>
                                    @lang('messages.restaurant_az_commissions_count')
                                </p>
                                <h3 class="text-center">
                                    {{App\Models\AzRestaurantCommission::wherePayment('true')->whereyear('created_at','=',$year)->whereMonth('created_at','=',$month)->count()}}
                                </h3>
                            </div>
                        </div>
                    </a>

                </div>
                <div class="col-lg-6 col-6">
                    <a href="{{route('reports.commissions' , [$year , $month])}}">
                        <!-- small box -->
                        <div class="small-box">
                            <div class="inner">
                                <p>@lang('messages.paid_commission_value')</p>

                                <h3 class="text-center">
                                    {{number_format((float)$restaurant_commissions, 0, '.', '')}} @lang('messages.SR')
                                </h3>
                            </div>
                        </div>
                    </a>
                </div>
            </div>

        </div>
    </section>
    <!-- /.content -->
@endsection
<style>
    .row, h4, .content-heade, .content {
        font-family: 'cairo' !important;
    }

    .col-lg-3, .col-lg-6 {
        transtion: all 0.3s linear;
    }

    .col-lg-3:hover, .col-lg-6:hover {
        /*background-color:red;*/
        transform: translateY(-0.5rem);
    }

    a {
        color: black !important;
    }

    a:hover {
        text-decoration: none !important;
    }

    .small-box {
        height: 89%;
    }

</style>
