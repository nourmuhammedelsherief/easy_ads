@extends('restaurant.lteLayout.master')

@section('title')
    @lang('messages.easyAdsSubscription')
@endsection

@section('styles')
@endsection

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1> @lang('messages.easyAdsSubscription') </h1>
                </div>

            </div>
        </div><!-- /.container-fluid -->
    </section>
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <!-- left column -->
                <div class="col-md-8">
                    <!-- general form elements -->
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title"> @lang('messages.easyAdsSubscription') </h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        <form role="form" action="{{ route('EasyAdsPaymentMethod' , auth('restaurant')->user()->id) }}"
                              method="get"
                              enctype="multipart/form-data">
                            <input type='hidden' name='_token' value='{{ Session::token() }}'>

                            <div class="card-body">
                                <div class="form-group">
                                    <label class="control-label"> @lang('messages.payment_method') </label>
                                    <select name="payment_method" class="form-control" onchange="showDiv(this)"
                                            required>
                                        <option disabled selected> @lang('messages.choose_one') </option>
                                        @if($setting->bank_transfer == 'true')
                                            <option value="bank"> @lang('messages.bank_transfer') </option>
                                        @endif
                                        @if($setting->online_payment != 'none')
                                            <option value="online"> @lang('messages.online') </option>
                                        @endif
                                        {{--                                        <option value="payKink"> @lang('messages.payLink') </option>--}}
                                    </select>
                                    @if ($errors->has('payment_method'))
                                        <span class="help-block">
                                            <strong
                                                style="color: red;">{{ $errors->first('payment_method') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div id="online" style="display: none">
                                    <div class="form-group">
                                        <label class="control-label"> @lang('messages.online_payment_type') </label>
                                        <select name="payment_type" class="form-control" required>
                                            <option disabled selected> @lang('messages.choose_one') </option>
                                            {{--                                        <option value="1"> @lang('messages.kent') </option>--}}
                                            <option value="2"> @lang('messages.visa') </option>
                                            {{--                                        <option value="3"> @lang('messages.amex') </option>--}}
                                            {{--                                        <option value="5"> @lang('messages.benefit') </option>--}}
                                            <option value="6"> @lang('messages.mada') </option>
                                            <option value="11"> @lang('messages.apple_pay') </option>
                                            <option value="14"> @lang('messages.stc_pay') </option>
                                        </select>
                                        @if ($errors->has('payment_type'))
                                            <span class="help-block">
                                                <strong
                                                    style="color: red;">{{ $errors->first('payment_type') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label"> @lang('messages.seller_code') </label>
                                    <input type="text" name="seller_code" class="form-control"
                                           value="{{ old('seller_code') }}"
                                           placeholder="{{ app()->getLocale() == 'ar' ? 'أذا لديك كود خصم أكتبه هنا' : 'Put Your Seller Code Here' }}">
                                    @if ($errors->has('seller_code'))
                                        <span class="help-block">
                                            <strong style="color: red;">{{ $errors->first('seller_code') }}</strong>
                                        </span>
                                    @endif
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
        function showDiv(element) {
            if (element.value == 'online' && {{$setting->online_payment == 'myFatoourah'}}) {
                document.getElementById('online').style.display = 'block';
            } else if (element.value == 'bank') {
                document.getElementById('online').style.display = 'none';
            } else {
                document.getElementById('online').style.display = 'none';
            }
        }
    </script>
@endsection
