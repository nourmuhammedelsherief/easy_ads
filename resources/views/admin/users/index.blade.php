@extends('admin.lteLayout.master')

@section('title')
    @lang('messages.clients')
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
                    <h1>@lang('messages.clients')</h1>
                </div>

            </div>
        </div><!-- /.container-fluid -->
    </section>
    @include('flash::message')
    <section class="content">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <!-- /.card-header -->
                    <div class="card-body">
                        <table id="example1" class="table table-striped">
                            <thead>
                            <tr>
                                <th>
                                    <label class="mt-checkbox mt-checkbox-single mt-checkbox-outline">
                                        <input type="checkbox" class="group-checkable"
                                               data-set="#sample_1 .checkboxes"/>
                                        <span></span>
                                    </label>
                                </th>
                                <th></th>
                                <th>@lang('messages.name')</th>
                                <th>@lang('messages.phone_number')</th>
                                <th>@lang('messages.country')</th>
                                <th>@lang('messages.email')</th>
                                {{--                                <th>@lang('messages.city')</th>--}}
                                {{--                                <th>@lang('messages.restaurant')</th>--}}
                                <th>@lang('messages.created_at')</th>
                                {{--                                <th>@lang('messages.operations')</th>--}}
                            </tr>
                            </thead>
                            <tbody>
                            <?php $i = 0 ?>
                            @foreach($users as $user)
                                <tr class="odd gradeX">
                                    <td>
                                        <label class="mt-checkbox mt-checkbox-single mt-checkbox-outline">
                                            <input type="checkbox" class="checkboxes" value="1"/>
                                            <span></span>
                                        </label>
                                    </td>
                                    <td><?php echo ++$i ?></td>
                                    <td> {{$user->name}} </td>
                                    <td> {{$user->phone_number}} </td>
                                    <td> {{app()->getLocale() == 'ar' ? $user->country->name_ar : $user->country->name_en}} </td>
                                    <td>
                                        <a href="mailTo:{{$user->email}}">{{$user->email}}</a>
                                    </td>
                                    {{--                                    <td>--}}
                                    {{--                                        @if($user->city != null)--}}
                                    {{--                                            {{app()->getLocale() == 'ar' ? $user->city->name_ar : $user->city->name_en}}--}}
                                    {{--                                        @endif--}}
                                    {{--                                    </td>--}}
                                    {{--                                    <td>--}}
                                    {{--                                        @if(isset($user->registerRestaurant->id))--}}
                                    {{--                                            <a href="{{route('showRestaurant' , $user->registerRestaurant->id)}}">{{$user->registerRestaurant->name}}</a>--}}
                                    {{--                                        @endif--}}
                                    {{--                                    </td>--}}
                                    <td>
                                        {{$user->created_at->format('Y-m-d')}} ,
                                        {{\Carbon\Carbon::parse($user->created_at)->isoFormat('h:mm a')}}
                                    </td>
                                    {{--                                    <td>--}}
                                    {{--                                        <a class="btn btn-primary" href="{{route('clients.edit' , $user->id)}}">--}}
                                    {{--                                            <i class="fa fa-user-edit"></i>--}}
                                    {{--                                        </a>--}}
                                    {{--                                        @if(auth()->guard('admin')->user()->role == 'admin')--}}
                                    {{--                                            <a class="delete_city btn btn-danger" data="{{ $user->id }}"--}}
                                    {{--                                               data_name="{{ $user->name }}">--}}
                                    {{--                                                <i class="fa fa-trash"></i>--}}
                                    {{--                                            </a>--}}
                                    {{--                                        @endif--}}
                                    {{--                                    </td>--}}
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                {!! $users->withQueryString()->links('pagination::bootstrap-5') !!}
                <!-- /.card-body -->
                </div>
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </section>


@endsection

@section('scripts')
    <script src="{{asset('dist/js/adminlte.min.js')}}"></script>
    <script src="{{asset('plugins/datatables/jquery.dataTables.js')}}"></script>
    <script src="{{asset('plugins/datatables-bs4/js/dataTables.bootstrap4.js')}}"></script>
    <script src="{{ URL::asset('admin/js/sweetalert.min.js') }}"></script>
    <script src="{{ URL::asset('admin/js/ui-sweetalert.min.js') }}"></script>
    <script>
        $(function () {
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
        $(document).ready(function () {
            var CSRF_TOKEN = $('meta[name="X-CSRF-TOKEN"]').attr('content');

            $('body').on('click', '.delete_city', function () {
                var id = $(this).attr('data');

                var swal_text = 'حذف ' + $(this).attr('data_name') + '؟';
                var swal_title = 'هل أنت متأكد من الحذف ؟';

                swal({
                    title: swal_title,
                    text: swal_text,
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonClass: "btn-warning",
                    confirmButtonText: "تأكيد",
                    cancelButtonText: "إغلاق",
                    closeOnConfirm: false
                }, function () {

                    {{--var url = '{{ route("imageProductRemove", ":id") }}';--}}

                        {{--url = url.replace(':id', id);--}}

                        window.location.href = "{{ url('/') }}" + "/admin/clients/delete/" + id;

                });

            });

        });
    </script>

@endsection
