@extends('restaurant.lteLayout.master')
@section('title')
    @lang('messages.profile')
@endsection
@section('style')
    <link rel="stylesheet" href="{{ URL::asset('admin/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('admin/css/select2-bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('admin/css/bootstrap-fileinput.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <style>
        input[type=radio] {
            margin-right: 15px;
        }
    </style>
@endsection
@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>@lang('messages.profile')</h1>
                </div>
                <!--<div class="col-sm-6">-->
                <!--    <ol class="breadcrumb float-sm-right">-->
                <!--        <li class="breadcrumb-item"><a-->
            <!--                    href="{{ url('/restaurant/home') }}">@lang('messages.control_panel')</a></li>-->
            <!--        <li class="breadcrumb-item active"> @lang('messages.profile') </li>-->
                <!--    </ol>-->
                <!--</div>-->
            </div>
        </div><!-- /.container-fluid -->
    </section>
    @include('flash::message')
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header p-2">
                            <ul class="nav nav-pills">
                                <li class="nav-item"><a class="nav-link active" href="#subscription"
                                                        data-toggle="tab">@lang('messages.my_subscription')</a></li>
                                <li class="nav-item"><a class="nav-link " href="#main_data"
                                                        data-toggle="tab">@lang('messages.main_data')</a></li>
                                <li class="nav-item"><a class="nav-link" href="#change_password"
                                                        data-toggle="tab">@lang('messages.change_password')</a></li>
                                {{-- <li class="nav-item"><a class="nav-link" href="#external_data"
                                        data-toggle="tab">@lang('messages.external_data')</a></li> --}}
                                <li class="nav-item"><a class="nav-link" href="#colors"
                                                        data-toggle="tab">@lang('messages.site_colors')</a></li>
                                {{--                                <li class="nav-item">--}}
                                {{--                                    <a class="nav-link" href="#bio_colors" data-toggle="tab">--}}
                                {{--                                        {{ app()->getLocale() == 'ar' ? 'التحكم بألوان البايو' : 'Boi Colors Control' }}--}}
                                {{--                                    </a>--}}
                                {{--                                </li>--}}
                                {{--                                <li class="nav-item"><a class="nav-link" href="#barcode"--}}
                                {{--                                        data-toggle="tab">@lang('messages.my_barcode')--}}
                                {{--                                    </a>--}}
                                {{--                                </li>--}}


                            </ul>
                        </div><!-- /.card-header -->
                        <div class="card-body">
                            <div class="tab-content">
                                <div class="tab-pane" id="barcode">
                                    <form action="{{ route('RestaurantUpdateBarcode') }}" class="form-horizontal"
                                          method="post" enctype="multipart/form-data">
                                        @csrf
                                        <div class="form-group">
                                            <label for="name_ar"
                                                   class="col-sm-3 control-label">@lang('messages.name_ar')</label>

                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" name="name_ar"
                                                       value="{{ $user->name_ar }}" id="name_ar"
                                                       placeholder="@lang('messages.name_ar')">
                                            </div>
                                            @if ($errors->has('name_ar'))
                                                <div class="alert alert-danger">
                                                    <button class="close" data-close="alert"></button>
                                                    <span> {{ $errors->first('name_ar') }}</span>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="form-group">
                                            <label for="name_en"
                                                   class="col-sm-3 control-label">@lang('messages.name_en')</label>

                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" name="name_en"
                                                       value="{{ $user->name_en }}" id="name_en"
                                                       placeholder="@lang('messages.name_en')">
                                            </div>
                                            {{--                                            <h6 style="color: red">@lang('messages.whenChangeName')</h6> --}}
                                            @if ($errors->has('name_en'))
                                                <div class="alert alert-danger">
                                                    <button class="close" data-close="alert"></button>
                                                    <span> {{ $errors->first('name_en') }}</span>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="form-group">
                                            <label for="name_en"
                                                   class="col-sm-3 control-label">@lang('messages.name_barcode')</label>

                                            <div class="col-sm-9">
                                                <input disabled type="text" class="form-control" name="name_barcode"
                                                       value="{{ $user->name_barcode }}" id="name_en"
                                                       placeholder="@lang('messages.name_barcode')">
                                            </div>
                                            <h6 style="color: red">@lang('messages.whenChangeName')</h6>
                                            <a target="_blank" href="https://api.whatsapp.com/send?phone=966590136653"
                                               style="color: green">
                                                <i style="font-size:24px" class="fa">&#xf232;</i>
                                                <span class="hidemob">
                                                    @lang('messages.technical_support')
                                                </span>
                                            </a>
                                            @if ($errors->has('name_barcode'))
                                                <div class="alert alert-danger">
                                                    <button class="close" data-close="alert"></button>
                                                    <span> {{ $errors->first('name_barcode') }}</span>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="form-group">
                                            <div class="col-sm-offset-2 col-sm-10">
                                                <button type="submit"
                                                        class="btn btn-danger">@lang('messages.save')</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>

                                <div class="active tab-pane" id="subscription">
                                    <!-- The timeline -->
                                    <div class="timeline timeline-inverse">

                                        <div>
                                            <i class="fas fa-user bg-info"></i>

                                            <div class="timeline-item">
                                                <h3 class="timeline-header border-0">
                                                    @lang('messages.welcome')
                                                    <a href="#">
                                                        {{ app()->getLocale() == 'ar' ? $user->name_ar : $user->name_en }}
                                                    </a>
                                                    @lang('messages.at')
                                                    @lang('messages.control_panel')
                                                </h3>
                                            </div>
                                        </div>
                                        @php
                                            $subscription = $user->az_subscription;
                                        @endphp
                                        @if($subscription == null)
                                            <a href="{{route('EasyAdsSubscription' , $user->id)}}"
                                               class="btn btn-success">
                                                {{trans('messages.activeAzmak')}}
                                            </a>
                                        @elseif($subscription and $subscription->status == 'finished')
                                            <div>
                                                <i class="fas fa-money-bill bg-info"></i>
                                                <div class="timeline-item">
                                                    <h3 style="color: red" class="timeline-header border-0">
                                                        @lang('messages.finished_subscription')
                                                    </h3>
                                                </div>
                                            </div>
                                            <div>
                                                <i class="fas fa-money-bill bg-info"></i>
                                                <div class="timeline-item">
                                                    <h3 class="timeline-header border-0">
                                                        <a href="{{route('EasyAdsSubscription' , $user->id)}}"
                                                           class="btn btn-success">
                                                            {{trans('messages.renewAzmakSubscription')}}
                                                        </a>
                                                    </h3>
                                                </div>
                                            </div>

                                        @elseif($subscription and $subscription->status == 'active' )
                                            <div>
                                                <i class="fas fa-money-bill bg-info"></i>
                                                <div class="timeline-item">
                                                    <h3 class="timeline-header border-0">
                                                        @lang('messages.subscription_price')
                                                        <a href="#">
                                                            {{App\Models\EasyAdsSetting::first()->subscription_amount}}
                                                            {{app()->getLocale() == 'ar' ? $subscription->restaurant->country->currency_ar : $subscription->restaurant->country->currency_en}}
                                                        </a>
                                                    </h3>
                                                </div>
                                            </div>
                                            <div>
                                                <i class="fas fa-money-bill bg-info"></i>
                                                <div class="timeline-item">
                                                    <h3 class="timeline-header border-0">
                                                        @lang('messages.tax_value')
                                                        <a href="#">
                                                            {{$subscription->tax_value}}
                                                            {{app()->getLocale() == 'ar' ? $subscription->restaurant->country->currency_ar : $subscription->restaurant->country->currency_en}}
                                                        </a>
                                                    </h3>
                                                </div>
                                            </div>
                                            @if($subscription->discount_value)
                                                <div>
                                                    <i class="fas fa-money-bill bg-info"></i>
                                                    <div class="timeline-item">
                                                        <h3 class="timeline-header border-0">
                                                            @lang('messages.discount_value')
                                                            <a href="#">
                                                                {{$subscription->discount_value}}
                                                                {{app()->getLocale() == 'ar' ? $subscription->restaurant->country->currency_ar : $subscription->restaurant->country->currency_en}}
                                                            </a>
                                                        </h3>
                                                    </div>
                                                </div>
                                            @endif

                                            @if($subscription->seller_code)
                                                <div>
                                                    <i class="fas fa-money-bill bg-info"></i>
                                                    <div class="timeline-item">
                                                        <h3 class="timeline-header border-0">
                                                            @lang('messages.seller_code')
                                                            <a href="#">
                                                                {{$subscription->seller_code->seller_name}}
                                                            </a>
                                                        </h3>
                                                    </div>
                                                </div>
                                            @endif
                                            <div>
                                                <i class="fas fa-money-bill bg-info"></i>
                                                <div class="timeline-item">
                                                    <h3 class="timeline-header border-0">
                                                        @lang('messages.total_price')
                                                        <a href="#">
                                                            {{$subscription->price}}
                                                            {{app()->getLocale() == 'ar' ? $subscription->restaurant->country->currency_ar : $subscription->restaurant->country->currency_en}}
                                                        </a>
                                                    </h3>
                                                </div>
                                            </div>
                                            <div>
                                                <i class="fas fa-money-bill bg-info"></i>
                                                <div class="timeline-item">
                                                    <h3 class="timeline-header border-0">
                                                        @lang('messages.subscription_end_at')
                                                        <a href="#">
                                                            {{$subscription->end_at->format('Y-m-d')}}
                                                        </a>
                                                    </h3>
                                                </div>
                                            </div>
                                            <div>
                                                <i class="fas fa-money-bill bg-info"></i>
                                                <div class="timeline-item">
                                                    <h3 class="timeline-header border-0">
                                                        @lang('messages.total_menu_views')
                                                        <a href="#">
                                                            {{$user->az_info?->menu_views}}
                                                        </a>
                                                    </h3>
                                                </div>
                                            </div>
                                            <hr>
                                            <div>
                                                <i class="fas fa-money-bill bg-info"></i>
                                                <div class="timeline-item">
                                                    <h3 class="timeline-header border-0">
                                                        @lang('messages.restaurant_az_commission')
                                                        <a href="#">
                                                            {{$user->az_commission}} %
                                                        </a>
                                                    </h3>
                                                </div>
                                            </div>
                                            <div>
                                                <i class="fas fa-money-bill bg-info"></i>
                                                <div class="timeline-item">
                                                    <h3 class="timeline-header border-0">
                                                        @lang('messages.orders_commissions') :
                                                        <a href="#">
                                                            {{$user->az_orders->where('status' , '!=' , 'new')->sum('commission')}}
                                                            {{ app()->getLocale() == 'ar' ? $user->country->currency_ar : $user->country->currency_en }}
                                                        </a>
                                                    </h3>
                                                </div>
                                            </div>
                                            <div>
                                                <i class="fas fa-money-bill bg-info"></i>
                                                <div class="timeline-item">
                                                    <h3 class="timeline-header border-0">
                                                        @lang('messages.paid_commission_value') :
                                                        <a href="#">
                                                            {{$user->az_commissions->sum('commission_value')}}
                                                            {{ app()->getLocale() == 'ar' ? $user->country->currency_ar : $user->country->currency_en }}
                                                        </a>
                                                    </h3>
                                                </div>
                                            </div>
                                            <div>
                                                <i class="fas fa-money-bill bg-info"></i>
                                                <div class="timeline-item">
                                                    <h3 class="timeline-header border-0">
                                                        @lang('messages.commissions_payable') :
                                                        <a href="#">
                                                            {{$user->az_orders->where('status' , '!=' , 'new')->sum('commission') - $user->az_commissions->sum('commission_value')}}
                                                            {{ app()->getLocale() == 'ar' ? $user->country->currency_ar : $user->country->currency_en }}
                                                        </a>
                                                    </h3>
                                                </div>
                                            </div>
                                            @if($user->maximum_az_commission_limit)
                                                <div>
                                                    <i class="fas fa-money-bill bg-info"></i>
                                                    <div class="timeline-item">
                                                        <h3 class="timeline-header border-0">
                                                            @lang('messages.maximum_az_commission_limit') :
                                                            <a href="#">
                                                                {{$user->maximum_az_commission_limit}}
                                                                {{ app()->getLocale() == 'ar' ? $user->country->currency_ar : $user->country->currency_en }}
                                                            </a>
                                                        </h3>
                                                    </div>
                                                </div>
                                            @endif
                                        @elseif($subscription and $subscription->status == 'free' )
                                            <div>
                                                <i class="fas fa-money-bill bg-info"></i>
                                                <div class="timeline-item">
                                                    <h3 class="timeline-header border-0">
                                                        @lang('messages.subscription_type')
                                                        <a href="#">
                                                            @lang('messages.free_subscription')
                                                        </a>
                                                    </h3>
                                                </div>
                                            </div>

                                            <div>
                                                <i class="fas fa-money-bill bg-info"></i>
                                                <div class="timeline-item">
                                                    <h3 class="timeline-header border-0">
                                                        @lang('messages.subscription_end_at')
                                                        <a href="#">
                                                            {{$subscription->end_at->format('Y-m-d')}}
                                                        </a>
                                                    </h3>
                                                </div>
                                            </div>
                                            <div>
                                                <i class="fas fa-money-bill bg-info"></i>
                                                <div class="timeline-item">
                                                    <h3 class="timeline-header border-0">
                                                        @lang('messages.total_menu_views')
                                                        <a href="#">
                                                            {{$user->az_info?->menu_views}}
                                                        </a>
                                                    </h3>
                                                </div>
                                            </div>
                                            <hr>
                                            <div>
                                                <i class="fas fa-money-bill bg-info"></i>
                                                <div class="timeline-item">
                                                    <h3 class="timeline-header border-0">
                                                        @lang('messages.restaurant_az_commission')
                                                        <a href="#">
                                                            {{$user->az_commission}} %
                                                        </a>
                                                    </h3>
                                                </div>
                                            </div>
                                            <div>
                                                <i class="fas fa-money-bill bg-info"></i>
                                                <div class="timeline-item">
                                                    <h3 class="timeline-header border-0">
                                                        @lang('messages.orders_commissions') :
                                                        <a href="#">
                                                            {{$user->az_orders->where('status' , '!=' , 'new')->sum('commission')}}
                                                            {{ app()->getLocale() == 'ar' ? $user->country->currency_ar : $user->country->currency_en }}
                                                        </a>
                                                    </h3>
                                                </div>
                                            </div>
                                            <div>
                                                <i class="fas fa-money-bill bg-info"></i>
                                                <div class="timeline-item">
                                                    <h3 class="timeline-header border-0">
                                                        @lang('messages.paid_commission_value') :
                                                        <a href="#">
                                                            {{$user->az_commissions->sum('commission_value')}}
                                                            {{ app()->getLocale() == 'ar' ? $user->country->currency_ar : $user->country->currency_en }}
                                                        </a>
                                                    </h3>
                                                </div>
                                            </div>
                                            <div>
                                                <i class="fas fa-money-bill bg-info"></i>
                                                <div class="timeline-item">
                                                    <h3 class="timeline-header border-0">
                                                        @lang('messages.commissions_payable') :
                                                        <a href="#">
                                                            {{$user->az_orders->where('status' , '!=' , 'new')->sum('commission') - $user->az_commissions->sum('commission_value')}}
                                                            {{ app()->getLocale() == 'ar' ? $user->country->currency_ar : $user->country->currency_en }}
                                                        </a>
                                                    </h3>
                                                </div>
                                            </div>
                                            @if($user->maximum_az_commission_limit)
                                                <div>
                                                    <i class="fas fa-money-bill bg-info"></i>
                                                    <div class="timeline-item">
                                                        <h3 class="timeline-header border-0">
                                                            @lang('messages.maximum_az_commission_limit') :
                                                            <a href="#">
                                                                {{$user->maximum_az_commission_limit}}
                                                                {{ app()->getLocale() == 'ar' ? $user->country->currency_ar : $user->country->currency_en }}
                                                            </a>
                                                        </h3>
                                                    </div>
                                                </div>
                                            @endif
                                        @elseif($subscription and $subscription->status == 'commission_hold')
                                            <div>
                                                <i class="fas fa-money-bill bg-info"></i>
                                                <div class="timeline-item">
                                                    <h3 class="timeline-header border-0">
                                                        <span
                                                            style="color: red">@lang('messages.commissions_limit_exceed')</span>
                                                        :
                                                        <a href="#" class="btn btn-info">
                                                            @lang('messages.pay_commission')
                                                        </a>
                                                    </h3>
                                                </div>
                                            </div>

                                        @endif
                                        <div>
                                            <i class="far fa-clock bg-gray"></i>
                                        </div>
                                    </div>
                                </div>

                                <div class="tab-pane" id="main_data">
                                    <form action="{{ route('RestaurantUpdateProfile') }}" class="form-horizontal"
                                          method="post" enctype="multipart/form-data">
                                        @csrf

                                        {{--                                        <div class="form-group">--}}
                                        {{--                                            <label for="email"--}}
                                        {{--                                                   class="col-sm-3 control-label">@lang('messages.email')</label>--}}

                                        {{--                                            <div class="col-sm-9">--}}
                                        {{--                                                <input type="email" class="form-control" name="email"--}}
                                        {{--                                                       value="{{ $user->email }}" id="email"--}}
                                        {{--                                                       placeholder="@lang('messages.email')">--}}
                                        {{--                                            </div>--}}
                                        {{--                                            @if ($errors->has('email'))--}}
                                        {{--                                                <div class="alert alert-danger">--}}
                                        {{--                                                    <button class="close" data-close="alert"></button>--}}
                                        {{--                                                    <span> {{ $errors->first('email') }}</span>--}}
                                        {{--                                                </div>--}}
                                        {{--                                            @endif--}}
                                        {{--                                        </div>--}}
                                        {{--                                        <div class="form-group">--}}
                                        {{--                                            <label for="phone_number"--}}
                                        {{--                                                   class="col-sm-3 control-label">@lang('messages.phone_number')</label>--}}

                                        {{--                                            <div class="col-sm-9">--}}
                                        {{--                                                <input type="text" class="form-control" name="phone_number"--}}
                                        {{--                                                       value="{{ $user->phone_number }}" id="phone_number"--}}
                                        {{--                                                       placeholder="@lang('messages.phone_number')" disabled>--}}
                                        {{--                                            </div>--}}
                                        {{--                                            @if ($errors->has('phone_number'))--}}
                                        {{--                                                <div class="alert alert-danger">--}}
                                        {{--                                                    <button class="close" data-close="alert"></button>--}}
                                        {{--                                                    <span> {{ $errors->first('phone_number') }}</span>--}}
                                        {{--                                                </div>--}}
                                        {{--                                            @endif--}}
                                        {{--                                        </div>--}}

                                        {{-- default lang --}}
                                        <div class="form-group default_lang">
                                            <label for="lang"
                                                   class="col-sm-3 control-label">@lang('messages.default_lang')</label>

                                            <div class="col-sm-9">
                                                <input type="radio" name="lang" value="ar"
                                                    {{ $user->az_info->lang == 'ar' ? 'checked' : '' }}> @lang('messages.ar')
                                                <input type="radio" name="lang" value="en"
                                                    {{ $user->az_info->lang == 'en' ? 'checked' : '' }}> @lang('messages.en')
                                                <input type="radio" name="lang" value="both"
                                                    {{ $user->az_info->lang == 'both' ? 'checked' : '' }}> @lang('messages.both')
                                            </div>
                                            @if ($errors->has('lang'))
                                                <div class="alert alert-danger">
                                                    <button class="close" data-close="alert"></button>
                                                    <span> {{ $errors->first('lang') }}</span>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="form-group">
                                            <label for="cart"
                                                   class="col-sm-12 control-label">@lang('messages.menu_show_type')</label>

                                            <div class="col-sm-9">
                                                <input type="radio" name="menu_show_type" value="style1"
                                                    {{ $user->az_info->menu_show_type == 'style1' ? 'checked' : '' }}>
                                                <i class=" fas fa-list"></i>
                                                @lang('messages.style1')
                                                <input type="radio" name="menu_show_type" value="style2"
                                                    {{ $user->az_info->menu_show_type == 'style2' ? 'checked' : '' }}>
                                                <i class="far fa-image"></i>
                                                @lang('messages.style2')
                                                <input type="radio" name="menu_show_type" value="style3"
                                                    {{ $user->az_info->menu_show_type == 'style3' ? 'checked' : '' }}>
                                                <i class="fas fa-th-large "></i>
                                                @lang('messages.style3')
                                            </div>
                                            @if ($errors->has('menu_show_type'))
                                                <div class="alert alert-danger">
                                                    <button class="close" data-close="alert"></button>
                                                    <span> {{ $errors->first('menu_show_type') }}</span>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="form-group">
                                            <label for="cart"
                                                   class="col-sm-12 control-label">@lang('messages.commission_style')</label>

                                            <div class="col-sm-9">
                                                <input type="radio" name="commission_payment" value="restaurant"
                                                    {{ $user->az_info->commission_payment == 'restaurant' ? 'checked' : '' }}>
                                                <i class=" fas fa-user"></i>
                                                @lang('messages.restaurant')
                                                <input type="radio" name="commission_payment" value="user"
                                                    {{ $user->az_info->commission_payment == 'user' ? 'checked' : '' }}>
                                                <i class="far fa-user"></i>
                                                @lang('messages.user')

                                            </div>
                                            @if ($errors->has('commission_payment'))
                                                <div class="alert alert-danger">
                                                    <button class="close" data-close="alert"></button>
                                                    <span> {{ $errors->first('commission_payment') }}</span>
                                                </div>
                                            @endif
                                        </div>
                                        <h6>@lang('messages.az_restaurant_description')</h6>
                                        <div class="form-group">
                                            <label class="control-label"> @lang('messages.description_ar') </label>
                                            <textarea class="textarea" name="description_ar"
                                                      placeholder="@lang('messages.description_ar')"
                                                      style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; pediting: 10px;">{{ $user->az_info->description_ar }}</textarea>
                                            @if ($errors->has('description_ar'))
                                                <span class="help-block">
                                                        <strong
                                                            style="color: red;">{{ $errors->first('description_ar') }}</strong>
                                                    </span>
                                            @endif
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label"> @lang('messages.description_en') </label>
                                            <textarea class="textarea" name="description_en"
                                                      placeholder="@lang('messages.description_en')"
                                                      style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; pediting: 10px;">{{ $user->az_info->description_en }}</textarea>
                                            @if ($errors->has('description_en'))
                                                <span class="help-block">
                                                    <strong
                                                        style="color: red;">{{ $errors->first('description_en') }}</strong>
                                                    </span>
                                            @endif
                                        </div>
                                        {{-- logo --}}
                                        {{-- image editor --}}
                                        <div class="form-group type_image ">
                                            <label class="control-label col-md-3"> @lang('messages.az_logo') </label>
                                            <div class="col-md-9">
                                                <div class="fileinput fileinput-new" data-provides="fileinput">
                                                    <div class="fileinput-preview thumbnail" data-trigger="fileinput"
                                                         style="width: 200px; height: 150px; border: 1px solid black;">
                                                        @if ($user->az_logo != null)
                                                            <img
                                                                src="{{ asset('/uploads/restaurants/logo/' . $user->az_logo) }}">
                                                        @endif
                                                    </div>
                                                    <div>
                                                        <span class="btn red btn-outline btn-file">
                                                            <span
                                                                class="fileinput-new btn btn-info"> @lang('messages.choose_photo') </span>
                                                            <span class="fileinput-exists btn btn-primary"> @lang('messages.change')
                                                            </span>
                                                            <input type="file" name="logo">
                                                        </span>
                                                        <a href="javascript:;" class="btn btn-danger fileinput-exists"
                                                           data-dismiss="fileinput">
                                                            @lang('messages.remove')
                                                        </a>
                                                    </div>
                                                </div>
                                                @if ($errors->has('logo'))
                                                    <span class="help-block">
                                                        <strong
                                                            style="color: red;">{{ $errors->first('logo') }}</strong>
                                                    </span>
                                                @endif
                                            </div>

                                        </div>

                                        <div class="form-group">
                                            <div class="col-sm-offset-2 col-sm-10">
                                                <button type="submit"
                                                        class="btn btn-danger">@lang('messages.save')</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <!-- /.tab-pane -->
                                <div class="tab-pane" id="change_password">
                                    <form action="{{ route('RestaurantChangePassword') }}" class="form-horizontal"
                                          method="post" enctype="multipart/form-data">
                                        @csrf
                                        <div class="form-group">
                                            <label for="password"
                                                   class="col-sm-3 control-label">@lang('messages.password')</label>

                                            <div class="col-sm-9">
                                                <input type="password" class="form-control" name="password"
                                                       id="password" placeholder="@lang('messages.password')">
                                            </div>
                                            @if ($errors->has('password'))
                                                <div class="alert alert-danger">
                                                    <button class="close" data-close="alert"></button>
                                                    <span> {{ $errors->first('password') }}</span>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="form-group">
                                            <label for="password_confirmation"
                                                   class="col-sm-3 control-label">@lang('messages.password_confirmation')</label>

                                            <div class="col-sm-9">
                                                <input type="password" class="form-control" name="password_confirmation"
                                                       id="password_confirmation"
                                                       placeholder="@lang('messages.password_confirmation')">
                                            </div>
                                            @if ($errors->has('password_confirmation'))
                                                <div class="alert alert-danger">
                                                    <button class="close" data-close="alert"></button>
                                                    <span> {{ $errors->first('password_confirmation') }}</span>
                                                </div>
                                            @endif
                                        </div>

                                        <div class="form-group">
                                            <div class="col-sm-offset-2 col-sm-10">
                                                <button type="submit"
                                                        class="btn btn-danger">@lang('messages.save')</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <div class="tab-pane" id="external_data">
                                    <form action="{{ route('RestaurantChangeExternal') }}" class="form-horizontal"
                                          method="post" enctype="multipart/form-data">
                                        @csrf


                                        <div class="form-group">
                                            <label for="cart"
                                                   class="col-sm-12 control-label">@lang('dashboard.product_menu_view')</label>

                                            <div class="col-sm-9">
                                                <input type="radio" name="product_menu_view" value="theme-1"
                                                    {{ $user->product_menu_view == 'theme-1' ? 'checked' : '' }}>
                                                <i class=" fas fa-list"></i>
                                                @lang('dashboard._product_menu_view.theme-1')
                                                <input type="radio" name="product_menu_view" value="theme-2"
                                                    {{ $user->product_menu_view == 'theme-2' ? 'checked' : '' }}>
                                                <i class="far fa-image"></i>
                                                @lang('dashboard._product_menu_view.theme-2')
                                                <input type="radio" name="product_menu_view" value="theme-3"
                                                    {{ $user->product_menu_view == 'theme-3' ? 'checked' : '' }}>
                                                <i class="fas fa-th-large "></i>
                                                @lang('dashboard._product_menu_view.theme-3')
                                            </div>
                                            @if ($errors->has('product_menu_view'))
                                                <div class="alert alert-danger">
                                                    <button class="close" data-close="alert"></button>
                                                    <span> {{ $errors->first('product_menu_view') }}</span>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="form-group">
                                            <label for="cart"
                                                   class="col-sm-3 control-label">@lang('messages.categories_menu')</label>

                                            <div class="col-sm-9">
                                                <input type="radio" name="menu" value="vertical"
                                                    {{ $user->menu == 'vertical' ? 'checked' : '' }}> @lang('messages.vertical')
                                                <input type="radio" name="menu" value="horizontal"
                                                    {{ $user->menu == 'horizontal' ? 'checked' : '' }}> @lang('messages.horizontal')
                                            </div>
                                            @if ($errors->has('menu'))
                                                <div class="alert alert-danger">
                                                    <button class="close" data-close="alert"></button>
                                                    <span> {{ $errors->first('menu') }}</span>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="form-group">
                                            <label for="cart" class="col-sm-3 control-label">
                                                {{ app()->getLocale() == 'ar' ? 'عرض قائمه الفروع بالموقع' : 'show branches list at website' }}
                                            </label>

                                            <div class="col-sm-9">
                                                <input type="radio" name="show_branches_list" value="true"
                                                    {{ $user->show_branches_list == 'true' ? 'checked' : '' }}>
                                                @lang('messages.yes')
                                                <input type="radio" name="show_branches_list" value="false"
                                                    {{ $user->show_branches_list == 'false' ? 'checked' : '' }}>
                                                @lang('messages.no')
                                            </div>
                                            @if ($errors->has('show_branches_list'))
                                                <div class="alert alert-danger">
                                                    <button class="close" data-close="alert"></button>
                                                    <span> {{ $errors->first('show_branches_list') }}</span>
                                                </div>
                                            @endif
                                        </div>

                                        <div class="form-group">
                                            <div class="col-sm-offset-2 col-sm-10">
                                                <button type="submit"
                                                        class="btn btn-danger">@lang('messages.save')</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <div class="tab-pane" id="colors">

                                    <div class="form-group">
                                        <div class="col-sm-offset-2 col-sm-10">
                                            <a href="{{ route('Reset_to_main', $user->id) }}"
                                               class="btn btn-primary">@lang('messages.reset_to_main')
                                            </a>
                                        </div>
                                    </div>
                                    <form action="{{ route('RestaurantChangeColors', $user->id) }}"
                                          class="form-horizontal" method="post" enctype="multipart/form-data">
                                        @csrf
                                        <div class="form-group">
                                            <label class="control-label"> @lang('messages.main_heads') </label>
                                            <input name="main_heads" type="color" class="form-control"
                                                   value="{{ $user->az_color?->main_heads }}">
                                            @if ($errors->has('main_heads'))
                                                <span class="help-block">
                                                    <strong
                                                        style="color: red;">{{ $errors->first('main_heads') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label"> @lang('messages.icons') </label>
                                            <input name="icons" type="color" class="form-control"
                                                   value="{{ $user->az_color?->icons }}">
                                            @if ($errors->has('icons'))
                                                <span class="help-block">
                                                    <strong style="color: red;">{{ $errors->first('icons') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label"> @lang('messages.options_description') </label>
                                            <input name="options_description" type="color" class="form-control"
                                                   value="{{ $user->az_color?->options_description }}">
                                            @if ($errors->has('options_description'))
                                                <span class="help-block">
                                                    <strong
                                                        style="color: red;">{{ $errors->first('options_description') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label"> @lang('messages.background') </label>
                                            <input name="background" type="color" class="form-control"
                                                   value="{{ $user->az_color?->background }}">
                                            @if ($errors->has('background'))
                                                <span class="help-block">
                                                    <strong
                                                        style="color: red;">{{ $errors->first('background') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label"> @lang('messages.product_background') </label>
                                            <input name="product_background" type="color" class="form-control"
                                                   value="{{ $user->az_color?->product_background }}">
                                            @if ($errors->has('product_background'))
                                                <span class="help-block">
                                                    <strong
                                                        style="color: red;">{{ $errors->first('product_background') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label"> @lang('messages.category_background') </label>
                                            <input name="category_background" type="color" class="form-control"
                                                   value="{{ $user->az_color?->category_background }}">
                                            @if ($errors->has('category_background'))
                                                <span class="help-block">
                                                    <strong
                                                        style="color: red;">{{ $errors->first('category_background') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                        <div class="form-group">
                                            <div class="col-sm-offset-2 col-sm-10">
                                                <button type="submit"
                                                        class="btn btn-danger">@lang('messages.save')</button>
                                            </div>
                                        </div>
                                    </form>

                                </div>
                                <!-- /.tab-pane -->

                                <div class="tab-pane" id="settings">
                                    <form class="form-horizontal">
                                        <div class="form-group">
                                            <label for="inputName" class="col-sm-2 control-label">Name</label>

                                            <div class="col-sm-10">
                                                <input type="email" class="form-control" id="inputName"
                                                       placeholder="Name">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="inputEmail" class="col-sm-2 control-label">Email</label>

                                            <div class="col-sm-10">
                                                <input type="email" class="form-control" id="inputEmail"
                                                       placeholder="Email">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="inputName2" class="col-sm-2 control-label">Name</label>

                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" id="inputName2"
                                                       placeholder="Name">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="inputExperience"
                                                   class="col-sm-2 control-label">Experience</label>

                                            <div class="col-sm-10">
                                                <textarea class="form-control" id="inputExperience"
                                                          placeholder="Experience"></textarea>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="inputSkills" class="col-sm-2 control-label">Skills</label>

                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" id="inputSkills"
                                                       placeholder="Skills">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-sm-offset-2 col-sm-10">
                                                <div class="checkbox">
                                                    <label>
                                                        <input type="checkbox"> I agree to the <a href="#">terms and
                                                            conditions</a>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-sm-offset-2 col-sm-10">
                                                <button type="submit" class="btn btn-danger">Submit</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <!-- /.tab-pane -->
                            </div>
                            <!-- /.tab-content -->
                        </div><!-- /.card-body -->
                    </div>
                    <!-- /.nav-tabs-custom -->
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </div><!-- /.container-fluid -->
    </section>
    @php
        $itemId = $user->id;
        $imageUploaderUrl = route('restaurant.profile.update_image');
    @endphp
    @include('restaurant.products.product_image_modal')
@endsection
@section('scripts')
    <script src="{{ URL::asset('admin/js/select2.full.min.js') }}"></script>
    <script src="{{ URL::asset('admin/js/components-select2.min.js') }}"></script>
    <script src="{{ URL::asset('admin/js/bootstrap-fileinput.js') }}"></script>


    <script type="text/javascript">
        function yesnoCheck() {
            if (document.getElementById('yesCheck').checked) {
                document.getElementById('ifYes').style.display = 'none';
            } else {
                document.getElementById('ifYes').style.display = 'block';
            }
        }

        $(function () {
            $('input.lang').on('change', function () {
                console.log($(this));
                if ($('input[name=ar]:checked').val() === 'true' && $('input[name=en]:checked').val() === 'true') {
                    $('.form-group.default_lang').fadeIn(300);
                } else {
                    $('.form-group.default_lang').fadeOut(300);
                }
            });
        });
    </script>
@endsection
