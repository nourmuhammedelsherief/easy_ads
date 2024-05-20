@extends('restaurant.lteLayout.master')

@section('title')
    @lang('messages.add') @lang('messages.offers')
@endsection

@section('style')
    <link rel="stylesheet" href="{{ URL::asset('admin/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('admin/css/select2-bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('admin/css/bootstrap-fileinput.css') }}">
    <link href="{{ asset('admin') }}/bootstrap-fileinput/css/fileinput.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="{{ asset('admin/bootstrap-fileinput/css/fileinput.min.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/bootstrap-fileinput/css/fileinput-rtl.min.css') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1> @lang('messages.add') @lang('messages.offers') </h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">
                            <a href="{{ url('/restaurant/home') }}">@lang('messages.control_panel')</a>
                        </li>
                        <li class="breadcrumb-item active">
                            <a href="{{ route('offers.index') }}">
                                @lang('messages.offers')
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
                            <h3 class="card-title">@lang('messages.add') @lang('messages.offers') </h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        <form role="form" action="{{ route('offers.store') }}" method="post"
                            enctype="multipart/form-data">
                            <input type='hidden' name='_token' value='{{ Session::token() }}'>
                            <input type="hidden" name="image_name" value="">
                            <div class="card-body">
                                <div class="form-group">
                                    <label class="control-label"> @lang('messages.name') </label>
                                    <input name="name" type="text" class="form-control" value="{{ old('name') }}"
                                        placeholder="@lang('messages.name')">
                                    @if ($errors->has('name'))
                                        <span class="help-block">
                                            <strong style="color: red;">{{ $errors->first('name') }}</strong>
                                        </span>
                                    @endif
                                </div>

                                {{-- time --}}
                                <div class="form-group">
                                    <label class="control-label"> @lang('messages.time_activation') </label>
                                    <input name="time" type="radio" onclick="javascript:yesnoCheck();" value="true"
                                        placeholder="@lang('messages.time')" id="noCheck"> @lang('messages.yes')
                                    <input name="time" onclick="javascript:yesnoCheck();" type="radio" value="false"
                                        checked placeholder="@lang('messages.time')" id="yesCheck"> @lang('messages.no')
                                    @if ($errors->has('time'))
                                        <span class="help-block">
                                            <strong style="color: red;">{{ $errors->first('time') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <div id="ifYes" style="display:none">
                                        <div class="form-group">
                                            <label class="control-label"> @lang('messages.start_at') </label>
                                            <input name="start_at" type="time" class="form-control"
                                                value="{{ old('start_at') }}" placeholder="@lang('messages.start_at')">
                                            @if ($errors->has('start_at'))
                                                <span class="help-block">
                                                    <strong style="color: red;">{{ $errors->first('start_at') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label"> @lang('messages.end_at') </label>
                                            <input name="end_at" type="time" class="form-control"
                                                value="{{ old('end_at') }}" placeholder="@lang('messages.end_at')">
                                            @if ($errors->has('end_at'))
                                                <span class="help-block">
                                                    <strong style="color: red;">{{ $errors->first('end_at') }}</strong>
                                                </span>
                                            @endif
                                        </div>


                                        <label class="control-label"> @lang('messages.days') </label>
                                        <br>
                                        <input id="select-all" type="checkbox"><label for='select-all'>
                                            {{ app()->getLocale() == 'ar' ? 'اختيار الكل' : 'Choose All' }}</label>
                                        <br>

                                        <?php $days = \App\Models\Day::all(); ?>
                                        @foreach ($days as $day)
                                            <input type="checkbox" name="day_id[]" value="{{ $day->id }}">
                                            {{ app()->getLocale() == 'ar' ? $day->name_ar : $day->name_en }}
                                        @endforeach
                                        @if ($errors->has('day_id'))
                                            <span class="help-block">
                                                <strong style="color: red;">{{ $errors->first('day_id') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                {{-- image editor --}}
                                <div class="form-group image-editor-preview ">
                                    <div class="col-md-12">
                                        <span class="fileinput-new"> {{ trans('messages.photo') }}</span>
                                        <br>
                                        <div dir=rtl class="file-loading">
                                            <input type="file" name="photo" id="normal-image"
                                                accept=".png,.jpg,.jpeg" class="file" data-browse-on-zone-click="true">
                                        </div>
                                    </div>
                                </div>
                                {{-- <div class="form-group image-editor-preview">
                                    <label for="">{{ trans('messages.photo') }}</label>
                                    <label class="custom-label" data-toggle="tooltip"
                                        title="{{ trans('dashboard.change_image') }}">
                                        <img class="rounded" id="avatar"
                                            src="{{ asset(isset($offer->image_path) ? $offer->image_path : $restaurant->image_path) }}"
                                            alt="avatar">
                                        <input type="file" class="sr-only" id="image-uploader" data-product_id=""
                                            name="image" accept="image/*">
                                    </label>

                                    @error('image_name')
                                        <p class="text-center text-danger">{{ $message }}</p>
                                    @enderror
                                    <div class="progress">
                                        <div class="progress-bar progress-bar-striped progress-bar-animated"
                                            role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">
                                            0%</div>
                                    </div>
                                    <div class="alert text-center" role="alert"></div>
                                </div> --}}

                            </div>
                            <!-- /.card-body -->
                            <div class="alert alert-warning" role="alert">
                                <h4 class="alert-heading">{{ trans('dashboard.explain') }}</h4>
                                <p>{{ trans('dashboard.image_warning_size', ['size' => 'العرض يساوي الطول مرة ونص ']) }}</p>
                                <hr>
                                <p class="mb-0">{!! trans('dashboard.image_resize_hint') !!}
                                    <a href="https://redketchup.io/image-resizer" target="__blank" style="color : #007bff;"
                                        title="موقع لتغير حجم الصور"> موقع لتغير حجم الصور</a>
                                </p>
                            </div>
                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">@lang('messages.save')</button>
                            </div>

                        </form>
                    </div>

                </div>
            </div>

        </div><!-- /.container-fluid -->
    </section>

    @php
        // $itemId = $offer->id ;
        $editorRate = [3, 4];
        $imageUploaderUrl = route('restaurant.offer.update_image');
    @endphp
    @include('restaurant.products.product_image_modal')
@endsection

@section('scripts')
    <script src="{{ asset('admin') }}/bootstrap-fileinput/bootstrap-fileinput.js" type="text/javascript"></script>
    <script src="{{ asset('admin/bootstrap-fileinput/js/plugins/piexif.min.js') }}"></script>
    <script src="{{ asset('admin/bootstrap-fileinput/js/plugins/sortable.min.js') }}"></script>
    <script src="{{ asset('admin/bootstrap-fileinput/js/plugins/purify.min.js') }}"></script>
    <script src="{{ asset('admin/bootstrap-fileinput/js/fileinput.min.js') }}"></script>
    <script src="{{ asset('admin/bootstrap-fileinput/themes/fa/theme.js') }}"></script>



    <script src="{{ asset('admin/bootstrap-fileinput/locales/ar.js') }}"></script>
    <script type="text/javascript">
         $("#normal-image").fileinput({
            uploadUrl: "{{ route('restaurant.offer.update_image') }}",
            // enableResumableUpload: true,
            resumableUploadOptions: {
                // uncomment below if you wish to test the file for previous partial uploaded chunks
                // to the server and resume uploads from that point afterwards
                // testUrl: "http://localhost/test-upload.php"
            },
            uploadExtraData: {
                '_token': '{{ csrf_token() }}', // for access control / security 
               @if(isset($offer->id))
               'action': 'edit',
                'item_id': {{ $offer->id }},
               @else 

               'action': 'create',
                
               @endif
            },
            rtl: true,
            language: 'en',
            maxFileCount: 1,
            allowedFileTypes: ['image'],
            allowedFileExtensions: ['image'],
            showCancel: true,
            showRemove: true,
            showUpload: true,
            showCancel: true,
            initialPreview: [
                @if (isset($offer->id) and  !empty($offer->photo))
                    '{{ asset($offer->image_path) }}'
                @endif
            ],
            maxFilePreviewSize: 50240,
            initialPreviewAsData: true,
            overwriteInitial: true,

            initialPreviewAsData: true,
            initialPreviewFileType: 'image',
            initialPreviewConfig: [
                @if (isset($offer->id) and !empty($offer->photo))
                    {
                        caption: "Image",
                        // previewAsData: true,
                        key: "1"
                    }
                @endif
            ],
            theme: 'fa',
            // deleteUrl: "http://localhost/file-delete.php"
        }).on('fileuploaded', function(event, previewId, index, fileId) {
            var response = previewId.response;

            if (response.status == true) {
                $('input[name=image_name]').val(response.photo);
            }
        }).on('fileuploaderror', function(event, data, msg) {
            // console.log('File Upload Error', 'ID: ' + data.fileId + ', Thumb ID: ' + data.previewId);
            console.log(msg);
            console.log(data);
        }).on('filebatchuploadcomplete', function(event, preview, config, tags, extraData) {
            console.log('completed');
        });

        function yesnoCheck() {
            if (document.getElementById('yesCheck').checked) {
                document.getElementById('ifYes').style.display = 'none';
            } else {
                document.getElementById('ifYes').style.display = 'block';
            }
        }
    </script>
    <script>
        $("#select-all").click(function() {
            $("input[type=checkbox]").prop('checked', $(this).prop('checked'));
        });
    </script>
@endsection
