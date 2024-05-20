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
                                <th> @lang('messages.order_no') </th>
                                <th> @lang('messages.branch') </th>
                                <th> @lang('messages.city') </th>
                                <th> @lang('messages.user') </th>
                                <th> @lang('messages.status') </th>
                                <th> @lang('messages.commission') </th>
                                <th> @lang('messages.operations') </th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php $i = 0 ?>
                            @foreach($orders as $order)
                                <tr class="odd gradeX">
                                    <td>
                                        <label class="mt-checkbox mt-checkbox-single mt-checkbox-outline">
                                            <input type="checkbox" class="checkboxes" value="1"/>
                                            <span></span>
                                        </label>
                                    </td>
                                    <td><?php echo ++$i ?></td>
                                    <td>
                                        {{$order->order_id}}
                                    </td>
                                    <td>
                                        {{app()->getLocale() == 'ar' ? $order->branch->name_ar : $order->branch->name_en}}
                                    </td>
                                    <td>
                                        {{app()->getLocale() == 'ar' ? $order->branch->city->name_ar : $order->branch->city->name_en}}
                                    </td>
                                    <td>
                                        {{$order->user->name}}
                                    </td>
                                    <td>
                                        @switch($order->status)
                                            @case('active')
                                            @lang('messages.active')
                                            @break
                                            @case('completed')
                                            @lang('messages.completed')
                                            @break
                                            @case('finished')
                                            @lang('messages.finished')
                                            @break
                                            @case('canceled')
                                            @lang('messages.canceled')
                                            @break
                                            @default
                                            @lang('messages.new_not_paid')
                                        @endswitch
                                    </td>
                                    <td>
                                        {{$order->commission}}
                                        {{ app()->getLocale() == 'ar' ? $restaurant->country->currency_ar : $restaurant->country->currency_en }}
                                    </td>
                                    <td>
                                        <a class="btn btn-success" href="{{route('AdminOrderShow' , $order->id)}}">
                                            <i class="fa fa-eye"></i>
                                        </a>
{{--                                        <a class="delete_data btn btn-danger" data="{{ $order->id }}" data_name="{{ $order->order_id }}" >--}}
{{--                                            <i class="fa fa-trash"></i>--}}
{{--                                        </a>--}}
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
    {!! $orders->withQueryString()->links('pagination::bootstrap-5') !!}

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
            $('body').on('click', '.delete_data', function () {
                var id = $(this).attr('data');
                var swal_text = '{{trans('messages.delete')}} ' + $(this).attr('data_name');
                var swal_title = "{{trans('messages.deleteSure')}}";

                swal({
                    title: swal_title,
                    text: swal_text,
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonClass: "btn-warning",
                    confirmButtonText: "{{trans('messages.sure')}}",
                    cancelButtonText: "{{trans('messages.close')}}"
                }, function () {

                    window.location.href = "{{ url('/') }}" + "/restaurant/azmak_orders/delete/" + id;

                });

            });
        });
    </script>
@endsection

