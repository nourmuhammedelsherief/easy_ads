@extends('restaurant.lteLayout.master')

@section('title')
    @lang('messages.edit') @lang('messages.terms_conditions')
@endsection

@section('styles')

@endsection

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1> @lang('messages.edit') @lang('messages.terms_conditions') </h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">
                            <a href="{{url('/restaurant/home')}}">@lang('messages.control_panel')</a>
                        </li>
                        <li class="breadcrumb-item active">
                            <a href="{{route('restaurant.terms_conditions.index')}}">
                                @lang('messages.terms_conditions')
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
                            <h3 class="card-title">@lang('messages.edit') @lang('messages.terms_conditions') </h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        <form role="form" action="{{route('restaurant.terms_conditions.update' , $terms->id)}}"
                              method="post" enctype="multipart/form-data">
                            <input type='hidden' name='_token' value='{{Session::token()}}'>

                            <div class="card-body">
                                <div class="form-group">
                                    <label class="control-label"> @lang('messages.terms_ar') </label>
                                    <textarea class="textarea" name="terms_ar"
                                              placeholder="@lang('messages.terms_ar')"
                                              style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;">{{ $terms->terms_ar }}</textarea>
                                    @if ($errors->has('terms_ar'))
                                        <span class="help-block">
                                                <strong
                                                    style="color: red;">{{ $errors->first('terms_ar') }}</strong>
                                            </span>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label class="control-label"> @lang('messages.terms_en') </label>
                                    <textarea class="textarea" name="terms_en"
                                              placeholder="@lang('messages.terms_en')"
                                              style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;">{{ $terms->terms_en }}</textarea>
                                    @if ($errors->has('terms_en'))
                                        <span class="help-block">
                                                <strong
                                                    style="color: red;">{{ $errors->first('terms_en') }}</strong>
                                            </span>
                                    @endif
                                </div>

                            </div>
                            <!-- /.card-body -->
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
