@extends('admin.lteLayout.master')

@section('title')
    @lang('messages.edit') @lang('messages.restaurants')
@endsection

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1> @lang('messages.edit') @lang('messages.restaurants') </h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">
                            <a href="{{url('/admin/home')}}">@lang('messages.control_panel')</a>
                        </li>
                        <li class="breadcrumb-item active">
                            <a href="{{route('restaurants' , 'active')}}">
                                @lang('messages.restaurants')
                            </a>
                        </li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <!-- left column -->
                <div class="col-md-8">
                @include('flash::message')
                <!-- general form elements -->
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">@lang('messages.edit') @lang('messages.restaurants') </h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        <form role="form" action="{{route('updateRestaurant' , $restaurant->id)}}" method="post"
                              enctype="multipart/form-data">
                            <input type='hidden' name='_token' value='{{Session::token()}}'>

                            <div class="card-body">
{{--                                <div class="form-group">--}}
{{--                                    <label class="control-label"> @lang('messages.token_payment_type') </label>--}}
{{--                                    <select name="az_online_payment_type" class="form-control">--}}
{{--                                        <option disabled selected> @lang('messages.choose_one') </option>--}}
{{--                                        <option value="test" {{$restaurant->az_online_payment_type == 'test' ? 'selected' : ''}}> @lang('messages.test') </option>--}}
{{--                                        <option value="online" {{$restaurant->az_online_payment_type == 'online' ? 'selected' : ''}}> @lang('messages.online') </option>--}}
{{--                                    </select>--}}
{{--                                    @if ($errors->has('az_online_payment_type'))--}}
{{--                                        <span class="help-block">--}}
{{--                                            <strong style="color: red;">{{ $errors->first('az_online_payment_type') }}</strong>--}}
{{--                                        </span>--}}
{{--                                    @endif--}}
{{--                                </div>--}}
                                <div class="form-group">
                                    <label class="control-label"> @lang('messages.az_payment_type') </label>
                                    <select name="a_z_orders_payment_type" class="form-control">
                                        <option selected disabled> @lang('messages.choose_one')</option>
                                        <option value="myFatoourah" {{$restaurant->a_z_orders_payment_type == 'myFatoourah' ? 'selected' : ''}}> @lang('messages.myFatoourah') </option>
                                        <option value="tap" {{$restaurant->a_z_orders_payment_type == 'tap' ? 'selected' : ''}}> @lang('messages.tap') </option>
                                        <option value="edfa" {{$restaurant->a_z_orders_payment_type == 'edfa' ? 'selected' : ''}}> @lang('messages.edfa') </option>
                                        <option value="payLink" {{$restaurant->a_z_orders_payment_type == 'payLink' ? 'selected' : ''}}> @lang('messages.payLink') </option>
                                    </select>
                                    @if ($errors->has('a_z_orders_payment_type'))
                                        <span class="help-block">
                                            <strong style="color: red;">{{ $errors->first('a_z_orders_payment_type') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div id="myFatoourah" style="display: {{$restaurant->a_z_orders_payment_type == 'myFatoourah' ? 'block' : 'none'}}">
                                    <div class="form-group">
                                        <label class="control-label"> @lang('messages.a_z_myFatoourah_token') </label>
                                       <input name="a_z_myFatoourah_token" value="{{$restaurant->a_z_myFatoourah_token}}" class="form-control"
                                       placeholder="@lang('messages.a_z_myFatoourah_token')">
                                        @if ($errors->has('a_z_myFatoourah_token'))
                                            <span class="help-block">
                                            <strong style="color: red;">{{ $errors->first('a_z_myFatoourah_token') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>
                                <div id="tap" style="display: {{$restaurant->a_z_orders_payment_type == 'tap' ? 'block' : 'none'}}">
                                    <div class="form-group">
                                        <label class="control-label"> @lang('messages.a_z_tap_token') </label>
                                        <input name="a_z_tap_token" value="{{$restaurant->a_z_tap_token}}" class="form-control"
                                               placeholder="@lang('messages.a_z_tap_token')">
                                        @if ($errors->has('a_z_tap_token'))
                                            <span class="help-block">
                                            <strong style="color: red;">{{ $errors->first('a_z_tap_token') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>
                                <div id="edfa" style="display: {{$restaurant->a_z_orders_payment_type == 'edfa' ? 'block' : 'none'}}">
                                    <div class="form-group">
                                        <label class="control-label"> @lang('messages.a_z_edfa_merchant') </label>
                                        <input name="a_z_edfa_merchant" value="{{$restaurant->a_z_edfa_merchant}}" class="form-control"
                                               placeholder="@lang('messages.a_z_edfa_merchant')">
                                        @if ($errors->has('a_z_edfa_merchant'))
                                            <span class="help-block">
                                            <strong style="color: red;">{{ $errors->first('a_z_edfa_merchant') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label"> @lang('messages.a_z_edfa_password') </label>
                                        <input name="a_z_edfa_password" value="{{$restaurant->a_z_edfa_password}}" class="form-control"
                                               placeholder="@lang('messages.a_z_edfa_password')">
                                        @if ($errors->has('a_z_edfa_password'))
                                            <span class="help-block">
                                            <strong style="color: red;">{{ $errors->first('a_z_edfa_password') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>
                                <div id="payLink" style="display: {{$restaurant->a_z_orders_payment_type == 'payLink' ? 'block' : 'none'}}">
                                    <div class="form-group">
                                        <label class="control-label"> @lang('messages.pay_link_app_id') </label>
                                        <input name="pay_link_app_id" value="{{$restaurant->pay_link_app_id}}" type="text" class="form-control" placeholder="@lang('messages.pay_link_app_id')">
                                        @if ($errors->has('pay_link_app_id'))
                                            <span class="help-block">
                                            <strong style="color: red;">{{ $errors->first('pay_link_app_id') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label"> @lang('messages.pay_link_secret_key') </label>
                                        <input name="pay_link_secret_key" value="{{$restaurant->pay_link_secret_key}}" type="text" class="form-control" placeholder="@lang('messages.pay_link_secret_key')">
                                        @if ($errors->has('pay_link_secret_key'))
                                            <span class="help-block">
                                            <strong style="color: red;">{{ $errors->first('pay_link_secret_key') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>
                                <hr>
                                <h6 class="text-center">@lang('messages.restaurant_az_commission')</h6>
                                <div class="form-group">
                                    <label class="control-label"> @lang('messages.commission_value') </label>
                                    <div class="row">
                                        <div class="col-sm-9">
                                            <input name="az_commission" value="{{$restaurant->az_commission}}" type="number" class="form-control" placeholder="@lang('messages.commission_value')">
                                            @if ($errors->has('az_commission'))
                                                <span class="help-block">
                                            <strong style="color: red;">{{ $errors->first('az_commission') }}</strong>
                                        </span>
                                            @endif
                                        </div>
                                        <div class="col-sm-3">%</div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label"> @lang('messages.maximum_az_commission_limit') </label>
                                    <div class="row">
                                        <div class="col-sm-9">
                                            <input name="maximum_az_commission_limit" value="{{$restaurant->maximum_az_commission_limit}}" type="number" class="form-control" placeholder="@lang('messages.maximum_az_commission_limit')">
                                            @if ($errors->has('maximum_az_commission_limit'))
                                                <span class="help-block">
                                            <strong style="color: red;">{{ $errors->first('maximum_az_commission_limit') }}</strong>
                                        </span>
                                            @endif
                                        </div>
                                        <div class="col-sm-3">
                                            {{app()->getLocale() == 'ar' ? $restaurant->country->currency_ar : $restaurant->country->currency_en}}
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- /.card-body -->

                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">@lang('messages.confirm')</button>
                            </div>

                        </form>
                    </div>

                </div>
            </div>

        </div><!-- /.container-fluid -->
    </section>
@endsection
@section('scripts')
    <script>
        $(document).ready(function() {
            $('select[name="a_z_orders_payment_type"]').on('change', function() {
                var id = $(this).val();
                if($(this).val() == 'myFatoourah'){
                    document.getElementById('myFatoourah').style.display = 'block';
                    document.getElementById('edfa').style.display = 'none';
                    document.getElementById('tap').style.display = 'none';
                    document.getElementById('payLink').style.display = 'none';
                }else if ($(this).val() == 'tap'){
                    document.getElementById('tap').style.display = 'block';
                    document.getElementById('myFatoourah').style.display = 'none';
                    document.getElementById('edfa').style.display = 'none';
                    document.getElementById('payLink').style.display = 'none';
                }else if($(this).val() == 'edfa')
                {
                    document.getElementById('edfa').style.display = 'block';
                    document.getElementById('tap').style.display = 'none';
                    document.getElementById('myFatoourah').style.display = 'none';
                    document.getElementById('payLink').style.display = 'none';
                }
                else if($(this).val() == 'payLink')
                {
                    document.getElementById('edfa').style.display = 'none';
                    document.getElementById('tap').style.display = 'none';
                    document.getElementById('myFatoourah').style.display = 'none';
                    document.getElementById('payLink').style.display = 'block';
                }

            });
        });
    </script>
    <script>
        function showDiv(element) {
            if (element.value == 'online') {
                document.getElementById('hidden_div').style.display = element.value == 'online' ? 'block' : 'none';
            } else if (element.value == 'bank') {
                document.getElementById('hidden_div').style.display = element.value == 'bank' ? 'none' : 'none';
            }
        }
    </script>
    <script>
        $(document).ready(function () {
            // $('select[name=country_id]').trigger('change');
            $(document).on('submit', 'form', function () {
                $('button').attr('disabled', 'disabled');
            });
        });
    </script>
@endsection
