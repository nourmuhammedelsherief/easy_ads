@extends('restaurant.lteLayout.master')

@section('title')
    @lang('messages.edit') @lang('dashboard.header_footer')
@endsection

@section('style')
<link rel="stylesheet" href="{{ URL::asset('admin/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('admin/css/select2-bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('admin/css/bootstrap-fileinput.css') }}">
    <link rel="stylesheet" href="{{asset('plugins/select2/css/select2.css')}}">
    <link href="{{asset('admin')}}/bootstrap-fileinput/css/fileinput.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="{{ asset('admin/bootstrap-fileinput/css/fileinput.min.css') }}">
<link rel="stylesheet" href="{{ asset('admin/bootstrap-fileinput/css/fileinput-rtl.min.css') }}">
@endsection
@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1> @lang('messages.edit') @lang('dashboard.header_footer') </h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">
                            <a href="{{url('/restaurant/home')}}">@lang('messages.control_panel')</a>
                        </li>
                        <li class="breadcrumb-item active">
                            <a href="{{route('restaurant.related_code.index')}}">
                                @lang('dashboard.header_footer')
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
                            <h3 class="card-title">@lang('messages.edit') @lang('dashboard.header_footer') </h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        <form role="form" action="{{route('restaurant.related_code.update' , $item)}}" method="post"
                              enctype="multipart/form-data">
                            <input type='hidden' name='_token' value='{{Session::token()}}'>
                            @method('put')
                            <input type="hidden" name="video_path" value="">
                            <div class="card-body">
                                {{-- name --}}
                                <div class="form-group">
                                    <label class="control-label"> @lang('dashboard.entry.name') </label>
                                    <input name="name" type="text" class="form-control" rows="6"
                                            placeholder="@lang('dashboard.entry.name') ..." value="{{$item->name}}">
                                    @if ($errors->has('name'))
                                        <span class="help-block">
                                            <strong style="color: red;">{{ $errors->first('name') }}</strong>
                                        </span>
                                    @endif
                                </div>          
                                {{-- header --}}
                                <div class="form-group">
                                    <label class="control-label"> @lang('dashboard.header') </label>
                                    <textarea name="header" type="text" class="form-control" rows="6"
                                            placeholder="@lang('dashboard.header') ...">{!! $item->header !!}</textarea>
                                    @if ($errors->has('header'))
                                        <span class="help-block">
                                            <strong style="color: red;">{{ $errors->first('header') }}</strong>
                                        </span>
                                    @endif
                                </div>

                                {{-- footer --}}
                                <div class="form-group">
                                    <label class="control-label"> @lang('dashboard.footer') </label>
                                    <textarea name="footer" type="text" class="form-control" rows="6"
                                            placeholder="@lang('dashboard.footer') ...">{!! $item->footer !!}</textarea>
                                    @if ($errors->has('footer'))
                                        <span class="help-block">
                                            <strong style="color: red;">{{ $errors->first('footer') }}</strong>
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
@section('scripts')
  
<script src="{{asset('admin')}}/bootstrap-fileinput/js/fileinput.js" type="text/javascript"></script>
<script src="{{ asset('admin/bootstrap-fileinput/js/plugins/piexif.min.js') }}"></script>
<script src="{{ asset('admin/bootstrap-fileinput/js/plugins/sortable.min.js') }}"></script>
<script src="{{ asset('admin/bootstrap-fileinput/js/plugins/purify.min.js') }}"></script>
<script src="{{ asset('admin/bootstrap-fileinput/js/fileinput.min.js') }}"></script>
<script src="{{ asset('admin/bootstrap-fileinput/themes/fa/theme.js') }}"></script>

<script src="{{ asset('admin/bootstrap-fileinput/locales/ar.js') }}"></script>
<script src="https://use.fontawesome.com/52e183519a.js"></script>

    <script>
   
    </script>
    <script src="{{ URL::asset('admin/js/select2.full.min.js') }}"></script>
    <script src="{{ URL::asset('admin/js/components-select2.min.js') }}"></script>
    <script src="{{ URL::asset('admin/js/bootstrap-fileinput.js') }}"></script>
    <script src="{{asset('plugins/select2/js/select2.js')}}"></script>
    <script>
        $(function(){
           
        });
    </script>
@endsection
