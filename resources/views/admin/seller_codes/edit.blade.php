@extends('admin.lteLayout.master')

@section('title')
    @lang('messages.edit') @lang('messages.seller_codes')
@endsection

@section('styles')

@endsection

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1> @lang('messages.edit') @lang('messages.seller_codes') </h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">
                            <a href="{{url('/admin/home')}}">@lang('messages.control_panel')</a>
                        </li>
                        <li class="breadcrumb-item active">
                            <a href="{{route('seller_codes.index')}}">
                                @lang('messages.seller_codes')
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
                    <!-- general form elements -->
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">@lang('messages.edit') @lang('messages.seller_codes') </h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        <form role="form" action="{{route('seller_codes.update' , $seller_code->id)}}" method="post"
                              enctype="multipart/form-data">
                            <input type='hidden' name='_token' value='{{Session::token()}}'>

                            <div class="card-body">
                                <div class="form-group">
                                    <label class="control-label"> @lang('messages.country') </label>
                                    <select name="country_id" class="form-control" required>
                                        <option disabled selected> @lang('messages.choose_one') </option>
                                        @foreach($countries as $country)
                                            <option
                                                value="{{$country->id}}" {{$seller_code->country_id == $country->id ? 'selected' : ''}}>
                                                {{app()->getLocale() == 'ar' ? $country->name_ar : $country->name_en}}
                                            </option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('country_id'))
                                        <span class="help-block">
                                            <strong style="color: red;">{{ $errors->first('country_id') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                {{-- code --}}
                                <div class="form-group display-none">
                                    <label class="control-label"> @lang('messages.seller_name') </label>
                                    <input name="seller_name" type="text" class="form-control"
                                           value="{{$seller_code->seller_name}}"
                                           placeholder="@lang('messages.seller_name')">
                                    @if ($errors->has('seller_name'))
                                        <span class="help-block">
                                            <strong style="color: red;">{{ $errors->first('seller_name') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label class="control-label"> @lang('messages.permanent') </label>
                                    <select name="permanent" class="form-control" required>
                                        <option disabled selected> @lang('messages.choose_one') </option>
                                        <option
                                            value="true" {{$seller_code->permanent == 'true' ? 'selected' : ''}}> @lang('messages.yes') </option>
                                        <option
                                            value="false" {{$seller_code->permanent == 'false' ? 'selected' : ''}}> @lang('messages.no') </option>
                                    </select>
                                    @if ($errors->has('permanent'))
                                        <span class="help-block">
                                            <strong style="color: red;">{{ $errors->first('permanent') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                {{--                                <div class="form-group">--}}
                                {{--                                    <label class="control-label"> @lang('messages.percentage') </label>--}}
                                {{--                                    <input name="percentage" type="number" class="form-control" value="{{$seller_code->percentage}}" placeholder="@lang('messages.percentage')">--}}
                                {{--                                    @if ($errors->has('percentage'))--}}
                                {{--                                        <span class="help-block">--}}
                                {{--                                            <strong style="color: red;">{{ $errors->first('percentage') }}</strong>--}}
                                {{--                                        </span>--}}
                                {{--                                    @endif--}}
                                {{--                                </div>--}}
                                <div class="form-group">
                                    <label class="control-label"> @lang('messages.code_percentage') </label>
                                    <input name="code_percentage" type="number" class="form-control"
                                           value="{{$seller_code->code_percentage}}"
                                           placeholder="@lang('messages.code_percentage')">
                                    @if ($errors->has('code_percentage'))
                                        <span class="help-block">
                                            <strong style="color: red;">{{ $errors->first('code_percentage') }}</strong>
                                        </span>
                                    @endif
                                </div>

                                <div class="form-group">
                                    <label class="control-label"> @lang('messages.start_at') </label>
                                    <input name="start_at" type="date" class="form-control"
                                           value="{{$seller_code->start_at}}" placeholder="@lang('messages.start_at')">
                                    @if ($errors->has('start_at'))
                                        <span class="help-block">
                                            <strong style="color: red;">{{ $errors->first('start_at') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label class="control-label"> @lang('messages.end_at') </label>
                                    <input name="end_at" type="date" class="form-control"
                                           value="{{$seller_code->end_at}}" placeholder="@lang('messages.end_at')">
                                    @if ($errors->has('end_at'))
                                        <span class="help-block">
                                            <strong style="color: red;">{{ $errors->first('end_at') }}</strong>
                                        </span>
                                    @endif
                                </div>

                                <div class="form-group">
                                    <label class="control-label"> @lang('messages.activity') </label>
                                    <input name="active" type="radio"
                                           value="true" {{$seller_code->active == 'true' ? 'checked' : ''}}>@lang('messages.yes')
                                    <input name="active" type="radio"
                                           value="false" {{$seller_code->active == 'false' ? 'checked' : ''}}>@lang('messages.no')
                                    @if ($errors->has('active'))
                                        <span class="help-block">
                                            <strong style="color: red;">{{ $errors->first('active') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <!-- /.card-body -->
                            @method('PUT')
                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">@lang('messages.save')</button>
                            </div>

                        </form>
                    </div>

                </div>
            </div>

        </div><!-- /.container-fluid -->
    </section>
@endsection


@push('scripts')
    <script>
        $(function () {
            $('select[name=used_type]').on('change', function () {
                var tag = $(this);
                var sellerName = $('input[name=seller_name]');
                var customUrl = $('input[name=custom_url]');
                var both = $('select[name=type]');
                var package = $('#package_id');
                if (tag.val() == 'code') {
                    sellerName.parent().fadeIn(300);
                    both.parent().fadeIn(300);
                    customUrl.parent().fadeOut(300);
                    package.parent().fadeOut(300);
                    customUrl.prop('disabled', true);

                    package.prop('disabled', true);
                    sellerName.prop('disabled', false);
                    both.prop('disabled', false);
                } else {
                    sellerName.parent().fadeOut(300);
                    both.parent().fadeOut(300);
                    customUrl.parent().fadeIn(300);
                    package.parent().fadeIn(300);

                    both.prop('disabled', true);
                    customUrl.prop('disabled', false);
                    package.prop('disabled', false);
                    sellerName.prop('disabled', true);
                }
            });
            $('select[name=used_type]').trigger('change');
        });
    </script>
@endpush
