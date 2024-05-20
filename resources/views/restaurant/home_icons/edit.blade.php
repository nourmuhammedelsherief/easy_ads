@extends('restaurant.lteLayout.master')

@section('title')
    @lang('messages.edit') @lang('dashboard.home_icons')
@endsection

@section('style')
    <link rel="stylesheet" href="{{ URL::asset('admin/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('admin/css/select2-bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('admin/css/bootstrap-fileinput.css') }}">
@endsection
@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1> @lang('messages.edit') @lang('dashboard.home_icons') </h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">
                            <a href="{{ url('/restaurant/home') }}">@lang('messages.control_panel')</a>
                        </li>
                        <li class="breadcrumb-item active">
                            <a href="{{ route('restaurant.home_icons.index') }}">
                                @lang('dashboard.home_icons')
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
                            <h3 class="card-title">@lang('messages.edit') @lang('dashboard.home_icons') </h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        <form role="form" action="{{ route('restaurant.home_icons.update', $icon->id) }}" method="post"
                            enctype="multipart/form-data">
                            <input type='hidden' name='_token' value='{{ Session::token() }}'>

                            <div class="card-body">
                                @if (Auth::guard('restaurant')->user()->ar == 'true')
                                    <div class="form-group">
                                        <label class="control-label"> @lang('dashboard.entry.title_ar') </label>
                                        <input name="title_ar" type="text" class="form-control" required 
                                            value="{{ $icon->title_ar }}" placeholder="@lang('dashboard.entry.title_ar')">
                                        @if ($errors->has('title_ar'))
                                            <span class="help-block">
                                                <strong style="color: red;">{{ $errors->first('title_ar') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                @endif
                                    {{-- title_en --}}
                                <div class="form-group">
                                    <label class="control-label"> @lang('dashboard.entry.title_en') </label>
                                    <input name="title_en" type="text" required class="form-control" value="{{ $icon->title_en }}"
                                        placeholder="@lang('dashboard.entry.title_en')">
                                    @if ($errors->has('title_en'))
                                        <span class="help-block">
                                            <strong style="color: red;">{{ $errors->first('title_en') }}</strong>
                                        </span>
                                    @endif
                                </div>

                                <div class="form-group">
                                    <label class="control-label"> @lang('dashboard.entry.sort') </label>
                                    <input name="sort" type="text" class="form-control" value="{{ $icon->sort }}"
                                        placeholder="@lang('dashboard.entry.sort')">
                                    @if ($errors->has('sort'))
                                        <span class="help-block">
                                            <strong style="color: red;">{{ $errors->first('sort') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                @if ($icon->code == null)
                                    <div class="form-group">
                                        <label class="control-label"> @lang('dashboard.entry.link') </label>
                                        <input name="link" type="text" class="form-control"
                                            value="{{ $icon->link }}" placeholder="@lang('dashboard.entry.link')">
                                        @if ($errors->has('link'))
                                            <span class="help-block">
                                                <strong style="color: red;">{{ $errors->first('link') }}</strong>
                                            </span>
                                        @endif
                                    </div>

                                    
                                @endif
                                <div class="form-group ">
                                    <label class="control-label col-md-3"> @lang('dashboard.entry.image') </label>
                                    <div class="col-md-9">
                                        <div class="fileinput fileinput-new" data-provides="fileinput">
                                            <div class="fileinput-preview thumbnail" data-trigger="fileinput"
                                                style="width: 200px; height: 150px; border: 1px solid black;">
                                                @if ($icon->image != null)
                                                    <img src="{{ asset($icon->image_path) }}">
                                                @endif
                                            </div>
                                            <div>
                                                <span class="btn red btn-outline btn-file">
                                                    <span class="fileinput-new btn btn-info"> @lang('messages.choose_photo') </span>
                                                    <span class="fileinput-exists btn btn-primary"> @lang('messages.change')
                                                    </span>
                                                    <input type="file" name="image" accept="image/*"> </span>
                                                <a href="javascript:;" class="btn btn-danger fileinput-exists"
                                                    data-dismiss="fileinput"> @lang('messages.remove') </a>
                                            </div>
                                        </div>
                                        @if ($errors->has('image'))
                                            <span class="help-block">
                                                <strong style="color: red;">{{ $errors->first('image') }}</strong>
                                            </span>
                                        @endif
                                    </div>

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
