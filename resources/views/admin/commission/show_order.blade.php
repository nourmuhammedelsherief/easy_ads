@extends('admin.lteLayout.master')

@section('title')
    @lang('messages.orders')
@endsection

@section('style')
    <link rel="stylesheet" href="{{asset('plugins/datatables-bs4/css/dataTables.bootstrap4.css')}}">
    <link rel="stylesheet" href="{{ URL::asset('admin/css/sweetalert.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('admin/css/sweetalert.css') }}">
    <!-- Theme style -->
@endsection

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>
                        @lang('messages.az_orders')
                    </h1>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>
    @include('flash::message')

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="callout callout-info">
                        <h5>
                            <i class="fas fa-info"></i>
                            @lang('messages.order_status') :
                            @switch($order->status)
                                @case('active')
                                <a href="#" class="btn btn-success"> @lang('messages.active') </a>
                                @break
                                @case('completed')
                                <a href="#" class="btn btn-info">@lang('messages.completed')</a>
                                @break
                                @case('finished')
                                <a href="#" class="btn btn-danger">@lang('messages.finished')</a>
                                @break
                                @case('canceled')
                                <a href="#" class="btn btn-danger">@lang('messages.canceled')</a>
                                @break
                                @default
                                <a href="#" class="btn btn-danger">@lang('messages.new_not_paid')</a>
                            @endswitch
                        </h5>
                    </div>
                    <!-- Main content -->
                    <div class="invoice p-3 mb-3" id="barcode-svg">
                        <!-- title row -->
                        <div class="row">
                            <div class="col-12">
                                <h4>
                                    <i class="fas fa-globe"></i> @lang('messages.azema_details')
                                    <small class="float-right">@lang('messages.date')
                                        : {{$order->created_at->format('d-m-Y')}}</small>
                                </h4>
                            </div>
                            <!-- /.col -->
                        </div>
                        <!-- info row -->
                        <div class="row invoice-info">
                            <div class="col-sm-4 invoice-col">
                                @lang('messages.from')
                                <address>
                                    <strong>{{$order->user->name}}.</strong><br>
                                    @lang('messages.phone_number') : <a
                                        href="tel:{{$order->user->phone_number}}">{{$order->user->phone_number}}</a><br>
                                    @lang('messages.email') : <a
                                        href="mailTo:{{$order->user->email}}">{{$order->user->email}}</a>
                                </address>
                            </div>
                            <!-- /.col -->
                            <div class="col-sm-4 invoice-col">
                                @lang('messages.to')
                                <address>
                                    <strong>{{$order->person_name}}</strong><br>
                                    @lang('messages.phone_number') : <a
                                        href="tel:{{$order->person_phone}}">{{$order->person_phone}}</a><br>
                                    @lang('messages.personOccasion') : {{$order->occasion}}<br>
                                    @lang('messages.message') :
                                    {!!  substr(strip_tags($order->occasion_message), 0, 30) !!}
                                </address>
                            </div>
                            <!-- /.col -->
                            <div class="col-sm-4 invoice-col">
                                <b>@lang('messages.order_no') :</b> {{$order->order_id}}<br>
                                <b>@lang('messages.payment_date') : </b> {{$order->created_at->format('d-m-Y')}}<br>
                            </div>
                            <!-- /.col -->
                        </div>
                        <!-- /.row -->

                        <!-- Table row -->
                        <h3 class="text-center"> @lang('messages.order_items') </h3>
                        <div class="row">
                            <div class="col-12 table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                    <tr>
                                        <th>@lang('messages.qty')</th>
                                        <th>@lang('messages.product')</th>
                                        <th>@lang('messages.size')</th>
                                        <th>@lang('messages.description')</th>
                                        <th>@lang('messages.price')</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($order->items as $item)
                                        <tr>
                                            <td>{{$item->product_count}}</td>
                                            <td>{{app()->getLocale() == 'ar' ? $item->product->name_ar : $item->product->name_en}}</td>
                                            <td>
                                                @if($item->size)
                                                    {{app()->getLocale() == 'ar' ? $item->size->name_ar : $item->size->name_en}}
                                                @endif
                                            </td>
                                            <td>
                                                {!! app()->getLocale() == 'ar' ? $item->product->description_ar : $item->product->description_en !!}
                                            </td>
                                            <td>
                                                {{$item->price}}
                                                {{app()->getLocale() == 'ar' ? $order->restaurant->country->currency_ar : $order->restaurant->country->currency_en}}
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <!-- /.col -->
                        </div>
                        <!-- /.row -->

                        <div class="row">
                            <!-- accepted payments column -->
                            <!-- /.col -->
                            <div class="col-sm-2"></div>
                            <div class="col-sm-8">
                                {{--                                <p class="lead">Amount Due 2/22/2014</p>--}}

                                <div class="table-responsive">
                                    <table class="table">
                                        <tr>
                                            <th style="width:50%">@lang('messages.order_price'):</th>
                                            <td>
                                                {{$order->order_price}}
                                                {{app()->getLocale() == 'ar' ? $order->restaurant->country->currency_ar : $order->restaurant->country->currency_en}}
                                            </td>
                                        </tr>
                                        {{--                                        <tr>--}}
                                        {{--                                            <th>@lang('messages.tax')</th>--}}
                                        {{--                                            <td>--}}
                                        {{--                                                {{$order->tax}}--}}
                                        {{--                                                {{app()->getLocale() == 'ar' ? $order->restaurant->country->currency_ar : $order->restaurant->country->currency_en}}--}}
                                        {{--                                            </td>--}}
                                        {{--                                        </tr>--}}
                                        <tr>
                                            <th>@lang('messages.total_price') :</th>
                                            <td>
                                                {{$order->total_price}}
                                                {{app()->getLocale() == 'ar' ? $order->restaurant->country->currency_ar : $order->restaurant->country->currency_en}}
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                            <div class="col-sm-2"></div>
                            <!-- /.col -->
                        </div>
                        <!-- /.row -->

                        <!-- this row will not appear when printing -->
                        <div class="row no-print">
                            <div class="col-sm-4">
                                <a href="#" id="printPage" class="btn btn-default">
                                    <i class="fas fa-print"></i> @lang('messages.print')
                                </a>
{{--                                @if($order->status == 'active' or $order->status == 'new')--}}
{{--                                    <a href="{{route('cancelAzmakOrder' , $order->id)}}" class="btn btn-danger">--}}
{{--                                        <i class="far fa-credit-card"></i>--}}
{{--                                        @lang('messages.cancel_order')--}}
{{--                                    </a>--}}
{{--                                @endif--}}
                            </div>
{{--                            @if($order->status == 'active')--}}
{{--                                <div class="col-sm-4">--}}
{{--                                    <form method="post" action="{{route('completeAzmakOrder' , $order->id)}}">--}}
{{--                                        @csrf--}}
{{--                                        <input type="text" name="order_code" required class="form-control"--}}
{{--                                               placeholder="@lang('messages.enterOrderCode')">--}}
{{--                                        <button type="submit" class="btn btn-primary float-right"--}}
{{--                                                style="margin-right: 5px;">--}}
{{--                                            <i class="fas fa-download"></i>--}}
{{--                                            @lang('messages.complete_order')--}}
{{--                                        </button>--}}
{{--                                        @if ($errors->has('order_code'))--}}
{{--                                            <span class="help-block">--}}
{{--                                                <strong style="color: red;">{{ $errors->first('order_code') }}</strong>--}}
{{--                                            </span>--}}
{{--                                        @endif--}}
{{--                                    </form>--}}
{{--                                </div>--}}
{{--                            @endif--}}
                        </div>
                    </div>
                    <!-- /.invoice -->
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </section>
@endsection

@section('scripts')
    <script src="{{asset('dist/js/html2canvas.min.js')}}"></script>

    <script>
        $(document).ready(function () {

            document.getElementById("printPage").addEventListener("click", function () {
                html2canvas(document.getElementById("barcode-svg")).then(function (canvas) {
                    var anchorTag = document.createElement("a");
                    document.body.appendChild(anchorTag);
                    // document.getElementById("previewImg").appendChild(canvas);
                    anchorTag.download = "{{$order->order_id}}-barcode.jpg";
                    anchorTag.href = canvas.toDataURL();
                    anchorTag.target = '_blank';
                    anchorTag.click();
                });
            });
        });
    </script>
@endsection

