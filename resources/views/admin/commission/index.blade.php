@extends('admin.lteLayout.master')

@section('title')
    @lang('messages.restaurant_commissions')
@endsection

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">
                        @lang('messages.restaurant_commissions')
                        ({{app()->getLocale() == 'ar' ? $restaurant->name_ar : $restaurant->name_en }})
                    </h1>
                </div>
                <!-- /.col -->

            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <!-- Small boxes (Stat box) -->
            <div class="row">
                <div class="col-lg-3 col-6"></div>
                <div class="col-lg-6 col-xs-6">
                    <!-- small box -->
                    <div class="small-box bg-green">
                        <div class="inner">
                            <p>
                                @lang('messages.restaurant_az_commission') :  {{$restaurant->az_commission}} %
                            </p>
                            <p>
                                @lang('messages.commissions_payable') :
                                <span style="color: red">
                                    {{$orders_commissions - $restaurant_commissions}}
                                    {{ app()->getLocale() == 'ar' ? $restaurant->country->currency_ar : $restaurant->country->currency_en }}
                                </span>
                            </p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-stats-bars"></i>
                        </div>
{{--                        <a href="#" class="small-box-footer"><i class="fa fa-arrow-circle-left"></i> اطلاعات بیشتر </a>--}}
                    </div>
                </div>
                <div class="col-lg-3 col-3"></div>
                <hr>
                <div class="col-lg-6 col-xs-6">
                    <!-- small box -->
                    <div class="small-box bg-yellow">
                        <div class="inner">
                            <p>
                                @lang('messages.restaurant_az_orders_count') :
                                {{$restaurant->az_orders->where('status' , '!=' , 'new')->count()}}
                            </p>
                            <p>
                                @lang('messages.orders_commissions') :
                                <span style="color: blue">
                                    {{$orders_commissions}}
                                    {{ app()->getLocale() == 'ar' ? $restaurant->country->currency_ar : $restaurant->country->currency_en }}
                                </span>
                            </p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-stats-bars"></i>
                        </div>
                        <a href="{{route('AzRestaurantOrders' , $restaurant->id)}}" class="small-box-footer">
                            <i class="fa fa-arrow-circle-left"></i>
                            @lang('messages.show')
                        </a>
                    </div>
                </div>
                <div class="col-lg-6 col-xs-6">
                    <!-- small box -->
                    <div class="small-box bg-blue">
                        <div class="inner">
                            <p>
                                @lang('messages.restaurant_az_commissions_count') :
                                {{$restaurant->az_commissions()->wherePayment('true')->count()}}
                            </p>
                            <p>
                                @lang('messages.paid_commission_value') :
                                <span style="color: red">
                                    {{$restaurant_commissions}}
                                    {{ app()->getLocale() == 'ar' ? $restaurant->country->currency_ar : $restaurant->country->currency_en }}
                                </span>
                            </p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-stats-bars"></i>
                        </div>
                        <a href="{{route('AzRestaurantCommissionsHistory' , $restaurant->id)}}" class="small-box-footer">
                            <i class="fa fa-arrow-circle-left"></i>
                            @lang('messages.show')
                        </a>
                    </div>
                </div>
                <!-- ./col -->
            </div>
            <!-- /.row -->
            <!-- Main row -->
            <!-- /.row (main row) -->
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
@endsection
<style>
    .col-lg-4:hover {
        transtion: all 0.3s linear;
    }

    .col-lg-4:hover {
        /*background-color:red;*/
        transform: translateY(-0.5rem);
    }

    .inner h6 {
        /*background-color:blue;*/
        font-size: 0.9rem;
        font-weight: 400;
        font-family: 'Cairo', sans-serif;


    }

    .inner h3 {
        text-align: center;
        font-size: 1.8rem !important;
        font-family: 'Cairo', sans-serif;


    }

    a {
        color: black !important;
        font-family: 'Cairo', sans-serif;

    }

    a:hover {
        text-decoration: none !important;

    }

    .small-box {
        /*background-color:#960082 !important;*/
        height: 90%;
    }

    h1 {
        color: red !important;
        font-family: 'Cairo', sans-serif;

    }

    .text-dark {
        font-family: 'Cairo', sans-serif;

    }
</style>
