@extends('restaurant.lteLayout.master')

@section('title')
    @lang('dashboard.home_icons')
@endsection

@section('style')
    <link rel="stylesheet" href="{{ asset('plugins/datatables-bs4/css/dataTables.bootstrap4.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('admin/css/sweetalert.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('admin/css/sweetalert.css') }}">
    <!-- Theme style -->
@endsection

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>@lang('dashboard.home_icons')</h1>
                </div>
                <!--<div class="col-sm-6">-->
                <!--    <ol class="breadcrumb float-sm-right">-->
                <!--        <li class="breadcrumb-item">-->
                <!--            <a href="{{ url('/restaurant/home') }}">-->
                <!--                @lang('messages.control_panel')-->
                <!--            </a>-->
                <!--        </li>-->
                <!--        <li class="breadcrumb-item active">-->
                <!--            <a href="{{ route('restaurant.home_icons.index') }}"></a>-->
                <!--            @lang('dashboard.home_icons')-->
                <!--        </li>-->
                <!--    </ol>-->
                <!--</div>-->
            </div>
        </div><!-- /.container-fluid -->
    </section>
    @include('flash::message')

    <section class="content">
        <div class="row">
            <div class="col-12">
                <h3>
                    <a href="{{ route('restaurant.home_icons.create') }}" class="btn">
                        <i class="fa fa-plus"></i>
                        @lang('messages.add_new')
                    </a>
                </h3>
                <div class="card">

                    <!-- /.card-header -->
                    <div class="card-body">
                        <table id="example1" class="table  table-striped">
                            <thead>
                                <tr>
                                    {{-- <th>
                                    <label class="mt-checkbox mt-checkbox-single mt-checkbox-outline">
                                        <input type="checkbox" class="group-checkable"
                                               data-set="#sample_1 .checkboxes"/>
                                        <span></span>
                                    </label>
                                </th> --}}
                                    <th></th>
                                    <th> @lang('dashboard.entry.icon') </th>
                                    <th> @lang('dashboard.entry.title_ar') </th>
                                    <th> @lang('dashboard.entry.title_en') </th>
                                    <th> @lang('dashboard.entry.sort') </th>
                                    <th> @lang('dashboard.entry.status') </th>
                                    <th> @lang('dashboard.contact_us_status') </th>
                                    <th> @lang('dashboard.entry.link') </th>
                                    <th> @lang('messages.operations') </th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i = 0; ?>
                                @foreach ($icons as $icon)
                                    <tr class="odd gradeX">
                                        {{-- <td>
                                        <label class="mt-checkbox mt-checkbox-single mt-checkbox-outline">
                                            <input type="checkbox" class="checkboxes" value="1"/>
                                            <span></span>
                                        </label>
                                    </td> --}}
                                        <td><?php echo ++$i; ?></td>
                                        <td>
                                            @if (!empty($icon->image))
                                                <button type="button" class="btn btn-info" data-toggle="modal"
                                                    data-target="#modal-info-{{ $icon->id }}">
                                                    <i class="fa fa-eye"></i>
                                                    <img src="{{ asset($icon->image_path) }}" width="70" height="70">
                                                </button>
                                                <div class="modal fade" id="modal-info-{{ $icon->id }}">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content bg-info">
                                                            <div class="modal-header">
                                                                <h4 class="modal-title">
                                                                    @lang('dashboard.home_icon')
                                                                </h4>
                                                                <button type="button" class="close" data-dismiss="modal"
                                                                    aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <img src="{{ asset($icon->image_path) }}" width="475"
                                                                    height="400">
                                                            </div>
                                                            <div class="modal-footer justify-content-between">
                                                                <button type="button" class="btn btn-outline-light"
                                                                    data-dismiss="modal">
                                                                    @lang('messages.close')
                                                                </button>
                                                            </div>
                                                        </div>
                                                        <!-- /.modal-content -->
                                                    </div>
                                                    <!-- /.modal-dialog -->
                                                </div>
                                            @endif
                                        </td>
                                        <td>{{ $icon->title_ar }}</td>
                                        <td>{{ $icon->title_en }}</td>
                                        <td>{{ $icon->sort }}</td>
                                        <td>

                                            <span class="custom-switch {{ $icon->is_active == 'true' ? 'on' : 'off' }}"
                                                data-url_on="{{ route('restaurant.home_icons.change_status', [$icon->id, 'false']) }}"
                                                data-url_off="{{ route('restaurant.home_icons.change_status', [$icon->id, 'true']) }}">
                                                <span class="text">On</span>
                                                <span class="move"></span>
                                            </span>


                                        </td>
                                        <td>
                                            <span class="custom-switch {{ $icon->contact_us_is_active == 'true' ? 'on' : 'off' }}"
                                                data-url_on="{{ route('restaurant.home_icons.change_contact_status', [$icon->id, 'false']) }}"
                                                data-url_off="{{ route('restaurant.home_icons.change_contact_status', [$icon->id, 'true']) }}">
                                                <span class="text">On</span>
                                                <span class="move"></span>
                                            </span>
                                        </td>
                                        <td>
                                            <a href="{{ $icon->link }}" target="_blank">{{ $icon->link }}</a>
                                        </td>
                                        <td>

                                            <a class="btn btn-primary"
                                                href="{{ route('restaurant.home_icons.edit', $icon->id) }}">
                                                <i class="fa fa-user-edit"></i> 
                                            </a>
                                            @php
                                                $user = Auth::guard('restaurant')->user();
                                                
                                            @endphp
                                            @if ($user->type == 'restaurant' and $icon->code == null)
                                                <a class="delete_data btn btn-danger" data="{{ $icon->id }}"
                                                    data_name="{{ app()->getLocale() == 'ar' ? ($icon->title_ar == null ? $icon->title_en : $icon->title_ar) : ($icon->title_en == null ? $icon->title_ar : $icon->title_en) }}">
                                                    <i class="fa fa-trash"></i>
                                                </a>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <!-- /.card-body -->
                </div>
            </div>
            <!-- /.col -->
        </div>
        {{ $icons->links() }}
        <!-- /.row -->
    </section>
@endsection

@section('scripts')
    <script src="{{ asset('dist/js/adminlte.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables/jquery.dataTables.js') }}"></script>
    <script src="{{ asset('plugins/datatables-bs4/js/dataTables.bootstrap4.js') }}"></script>
    <script src="{{ URL::asset('admin/js/sweetalert.min.js') }}"></script>
    <script src="{{ URL::asset('admin/js/ui-sweetalert.min.js') }}"></script>
    <script>
        $(function() {
            $("#example1").DataTable({
                lengthMenu: [
                    [10, 25, 50, 100, -1],
                    [10, 25, 50, 100, 'All'],
                ],
            });
            $('#example2').DataTable({
                "paging": true,
                "lengthChange": false,
                "searching": false,
                "ordering": true,
                "info": true,
                "autoWidth": false,
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            $('body').on('click', '.delete_data', function() {
                var id = $(this).attr('data');
                var swal_text = '{{ trans('messages.delete') }} ' + $(this).attr('data_name');
                var swal_title = "{{ trans('messages.deleteSure') }}";

                swal({
                    title: swal_title,
                    text: swal_text,
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonClass: "btn-warning",
                    confirmButtonText: "{{ trans('messages.sure') }}",
                    cancelButtonText: "{{ trans('messages.close') }}"
                }, function() {

                    window.location.href = "{{ url('/') }}" +
                        "/restaurant/home_icons/delete/" + id;

                });

            });
        });
    </script>
@endsection
