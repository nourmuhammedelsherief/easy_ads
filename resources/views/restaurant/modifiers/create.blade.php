@extends('restaurant.lteLayout.master')

@section('title')
    @lang('messages.add') @lang('messages.modifiers')
@endsection


@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1> @lang('messages.add') @lang('messages.modifiers') </h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">
                            <a href="{{url('/restaurant/home')}}">@lang('messages.control_panel')</a>
                        </li>
                        <li class="breadcrumb-item active">
                            <a href="{{route('modifiers.index')}}">
                                @lang('messages.modifiers')
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
                            <h3 class="card-title">@lang('messages.add') @lang('messages.modifiers') </h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        <form role="form" action="{{route('modifiers.store')}}" method="post"
                              enctype="multipart/form-data">
                            <input type='hidden' name='_token' value='{{Session::token()}}'>

                            <div class="card-body">
                                @if(Auth::guard('restaurant')->user()->ar == 'true')
                                    <div class="form-group">
                                        <label class="control-label"> @lang('messages.name_ar') </label>
                                        <input name="name_ar" type="text" class="form-control"
                                               value="{{old('name_ar')}}"
                                               placeholder="@lang('messages.name_ar')">
                                        @if ($errors->has('name_ar'))
                                            <span class="help-block">
                                            <strong style="color: red;">{{ $errors->first('name_ar') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                @endif
                                @if(Auth::guard('restaurant')->user()->en == 'true')
                                    <div class="form-group">
                                        <label class="control-label"> @lang('messages.name_en') </label>
                                        <input name="name_en" type="text" class="form-control"
                                               value="{{old('name_en')}}"
                                               placeholder="@lang('messages.name_en')">
                                        @if ($errors->has('name_en'))
                                            <span class="help-block">
                                            <strong style="color: red;">{{ $errors->first('name_en') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                @endif
                                <div class="form-group">
                                    <label class="control-label"> @lang('messages.sort') </label>
                                    <input name="sort" type="text" class="form-control"
                                           value="{{old('sort') ?? $maxSort}}"
                                           placeholder="@lang('messages.sort')">
                                    @if ($errors->has('sort'))
                                        <span class="help-block">
                                        <strong style="color: red;">{{ $errors->first('sort') }}</strong>
                                    </span>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label class="control-label"> @lang('messages.activity') </label>
                                    <input name="is_ready" type="radio" value="true"> @lang('messages.yes')
                                    <input name="is_ready" type="radio" value="false"> @lang('messages.no')
                                    @if ($errors->has('is_ready'))
                                        <span class="help-block">
                                            <strong style="color: red;">{{ $errors->first('is_ready') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label class="control-label"> {{app()->getLocale() == 'ar' ? 'الاختيار  من الإضافة': 'Choose'}} </label>
                                    <input name="choose" type="radio" value="one"> {{app()->getLocale() == 'ar' ? 'واحد': 'one'}}
                                    <input name="choose" type="radio" value="multiple"> {{app()->getLocale() == 'ar' ? 'متعدد': 'Multiple'}}
                                    <input name="choose" type="radio" value="custom"> {{app()->getLocale() == 'ar' ? 'محدد': 'Custom'}}
                                    @if ($errors->has('choose'))
                                        <span class="help-block">
                                            <strong style="color: red;">{{ $errors->first('choose') }}</strong>
                                        </span>
                                    @endif
                                </div>

                                <div class="form-group custom_num" style="display: none;">
                                    <label class="control-label"> @lang('messages.custom_num') </label>
                                    <input name="custom" type="number" value="{{old('custom')}}" class="form-control">
                                    @if ($errors->has('custom'))
                                        <span class="help-block">
                                            <strong style="color: red;">{{ $errors->first('custom') }}</strong>
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
@push('scripts')
    <script>
        $(function(){

            $('input[name=choose]').on('change' , function(){
                console.log($(this).val());
                if($(this).prop('checked') && $(this).val() == 'custom'){
                    $('.custom_num').fadeIn(300);
                }else{
                    $('.custom_num').fadeOut(300);
                }
            });
            $('input[name=choose]').trigger('change');
        });
    </script>
@endpush
