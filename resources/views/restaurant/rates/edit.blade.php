@extends('restaurant.lteLayout.master')

@section('title')
    @lang('messages.edit') @lang('messages.rate_us')
@endsection

@section('styles')
    <link rel="stylesheet" href="{{ URL::asset('admin/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('admin/css/select2-bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('admin/css/bootstrap-fileinput.css') }}">
@endsection
@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1> @lang('messages.edit') @lang('messages.rate_us') </h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">
                            <a href="{{url('/restaurant/home')}}">@lang('messages.control_panel')</a>
                        </li>
                        <li class="breadcrumb-item active">
                            <a href="{{route('restaurant_rate_us.index')}}">
                                @lang('messages.rate_us')
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
                            <h3 class="card-title">@lang('messages.edit') @lang('messages.rate_us') </h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        <form role="form" action="{{route('restaurant_rate_us.update' , $rate->id)}}" method="post" enctype="multipart/form-data">
                            <input type = 'hidden' name = '_token' value = '{{Session::token()}}'>

                            <div class="card-body">
                                <div class="form-group">
                                    <label class="control-label"> @lang('messages.question_ar') </label>
                                    <input name="question_ar" type="text" class="form-control" value="{{$rate->question_ar}}" placeholder="@lang('messages.question_ar')">
                                    @if ($errors->has('question_ar'))
                                        <span class="help-block">
                                            <strong style="color: red;">{{ $errors->first('question_ar') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                {{-- question en --}}
                                <div class="form-group">
                                    <label class="control-label"> @lang('messages.question_en') </label>
                                    <input name="question_en" type="text" class="form-control" value="{{$rate->question_en}}" placeholder="@lang('messages.question_en')">
                                    @if ($errors->has('question_en'))
                                        <span class="help-block">
                                            <strong style="color: red;">{{ $errors->first('question_en') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label class="control-label"> {{app()->getLocale() == 'ar' ? 'خيارات متعددة' : 'more options'}} </label>
                                    <br>
                                    <input name="more_option" type="radio" {{$rate->more_option == 'five_rate' ? 'checked' : ''}} value="five_rate"> {{app()->getLocale() == 'ar' ? 'التقييم من 1 الي 5' : 'rate from 1 to 5'}}
                                    <input name="more_option" type="radio" {{$rate->more_option == 'ten_rate' ? 'checked' : ''}} value="ten_rate"> {{app()->getLocale() == 'ar' ? 'التقييم  من 1 الي 10' : 'rate from 1 to 10'}}
                                    @if ($errors->has('more_option'))
                                        <span class="help-block">
                                            <strong style="color: red;">{{ $errors->first('more_option') }}</strong>
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

@section('scripts')
    <script src="{{ URL::asset('admin/js/select2.full.min.js') }}"></script>
    <script src="{{ URL::asset('admin/js/components-select2.min.js') }}"></script>
    <script src="{{ URL::asset('admin/js/bootstrap-fileinput.js') }}"></script>

@endsection

