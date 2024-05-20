@extends('admin.lteLayout.master')

@section('title')
    @lang('messages.control_panel')
@endsection

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">@lang('messages.control_panel')</h1>
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
{{--                <div class="col-lg-4 col-6">--}}
{{--                    <a href="{{ url('/admin/restaurants/active') }}">--}}

{{--                        <!-- small box -->--}}
{{--                        <div class="small-box">--}}
{{--                            <!--bg-success-->--}}
{{--                            <div class="inner">--}}
{{--                                <p>@lang('messages.restaurants') (@lang('messages.active_restaurants'))</p>--}}

{{--                                <h3>--}}
{{--                                    {{\App\Models\AzSubscription::where('status', 'active')->count() }}--}}
{{--                                </h3>--}}

{{--                            </div>--}}
{{--                            <!--<div class="icon">-->--}}
{{--                            <!--    <i class="ion ion-person-add"></i>-->--}}
{{--                            <!--</div>-->--}}

{{--                        </div>--}}
{{--                    </a>--}}

{{--                </div>--}}
{{--                <div class="col-lg-4 col-6">--}}
{{--                    <a href="{{ url('/admin/restaurants/free') }}">--}}

{{--                        <!-- small box -->--}}
{{--                        <div class="small-box">--}}
{{--                            <!--bg-success-->--}}
{{--                            <div class="inner">--}}
{{--                                <p>@lang('messages.restaurants') (@lang('messages.free_restaurants'))</p>--}}

{{--                                <h3>--}}
{{--                                    {{\App\Models\AzSubscription::where('status', 'free')->count() }}--}}
{{--                                </h3>--}}

{{--                            </div>--}}
{{--                            <!--<div class="icon">-->--}}
{{--                            <!--    <i class="ion ion-person-add"></i>-->--}}
{{--                            <!--</div>-->--}}

{{--                        </div>--}}
{{--                    </a>--}}

{{--                </div>--}}
{{--                <div class="col-lg-4 col-6">--}}
{{--                    <!-- small box -->--}}
{{--                    <a href="{{ url('/admin/restaurants/new') }}">--}}

{{--                        <div class="small-box ">--}}
{{--                            <!--bg-blue-->--}}
{{--                            <div class="inner">--}}
{{--                                <p>--}}
{{--                                    @lang('messages.restaurants') @lang('messages.new_restaurants')--}}
{{--                                </p>--}}
{{--                                <h3>--}}
{{--                                    {{\App\Models\AzSubscription::where('status', 'new')->count() }}--}}
{{--                                </h3>--}}
{{--                            </div>--}}


{{--                        </div>--}}
{{--                    </a>--}}

{{--                </div>--}}
{{--                <div class="col-lg-4 col-6">--}}
{{--                    <!-- small box -->--}}
{{--                    <a href="{{ url('/admin/restaurants/finished') }}">--}}

{{--                        <div class="small-box ">--}}
{{--                            <!--bg-blue-->--}}
{{--                            <div class="inner">--}}
{{--                                <p>--}}
{{--                                    @lang('messages.restaurants') @lang('messages.finished_restaurants')--}}
{{--                                </p>--}}
{{--                                <h3>--}}
{{--                                    {{\App\Models\AzSubscription::where('status', 'finished')->count() }}--}}
{{--                                </h3>--}}
{{--                            </div>--}}


{{--                        </div>--}}
{{--                    </a>--}}

{{--                </div>--}}
{{--                <div class="col-lg-4 col-6">--}}
{{--                    <!-- small box -->--}}
{{--                    <a href="{{ url('/admin/seller_codes') }}">--}}

{{--                        <div class="small-box ">--}}
{{--                            <!--bg-blue-->--}}
{{--                            <div class="inner">--}}
{{--                                <p>--}}
{{--                                    @lang('messages.seller_codes')--}}
{{--                                </p>--}}
{{--                                <h3>--}}
{{--                                    {{\App\Models\AzSellerCode::count() }}--}}
{{--                                </h3>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </a>--}}
{{--                </div>--}}
{{--                <div class="col-lg-4 col-6">--}}
{{--                    <!-- small box -->--}}
{{--                    <a href="{{ url('/admin/az_bank_transfers') }}">--}}

{{--                        <div class="small-box ">--}}
{{--                            <!--bg-blue-->--}}
{{--                            <div class="inner">--}}
{{--                                <p>--}}
{{--                                    @lang('messages.subscription_bank_transfers')--}}
{{--                                </p>--}}
{{--                                <h3>--}}
{{--                                    {{\App\Models\AzSubscription::whereNotNull('transfer_photo')->wherePayment('false')->count() }}--}}
{{--                                </h3>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </a>--}}
{{--                </div>--}}
{{--                <div class="col-lg-4 col-6">--}}
{{--                    <!-- small box -->--}}
{{--                    <a href="{{ url('/admin/histories') }}">--}}

{{--                        <div class="small-box ">--}}
{{--                            <!--bg-blue-->--}}
{{--                            <div class="inner">--}}
{{--                                <p>--}}
{{--                                    @lang('messages.histories')--}}
{{--                                </p>--}}
{{--                                <h3>--}}
{{--                                    {{\App\Models\AzHistory::count() }}--}}
{{--                                </h3>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </a>--}}
{{--                </div>--}}

{{--                <div class="col-lg-4 col-6">--}}
{{--                    <!-- small box -->--}}
{{--                    <a href="{{ url('/admin/commission_bank_transfers') }}">--}}

{{--                        <div class="small-box ">--}}
{{--                            <!--bg-blue-->--}}
{{--                            <div class="inner">--}}
{{--                                <p>--}}
{{--                                    @lang('messages.commission_bank_transfers')--}}
{{--                                </p>--}}
{{--                                <h3>--}}
{{--                                    {{\App\Models\AzRestaurantCommission::whereNotNull('transfer_photo')->whereNull('admin_id')->wherePaymentType('bank')->wherePayment('false')->count() }}--}}
{{--                                </h3>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </a>--}}
{{--                </div>--}}
{{--                <div class="col-lg-4 col-6">--}}
{{--                    <!-- small box -->--}}
{{--                    <a href="{{ url('/admin/commission_histories') }}">--}}

{{--                        <div class="small-box ">--}}
{{--                            <!--bg-blue-->--}}
{{--                            <div class="inner">--}}
{{--                                <p>--}}
{{--                                    @lang('messages.commission_histories')--}}
{{--                                </p>--}}
{{--                                <h3>--}}
{{--                                    {{\App\Models\AzCommissionHistory::orderBy('id' , 'desc')->count()}}--}}
{{--                                </h3>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </a>--}}
{{--                </div>--}}
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

    /*.small-box:hover{*/
    /*                    background-color:#960082 !important;*/


    /*}*/
</style>
