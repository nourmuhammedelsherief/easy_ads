@extends('restaurant.lteLayout.master')

@section('title')
    @lang('messages.our_rates')
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
                    <h1>@lang('messages.our_rates')</h1>
                </div>
                <!--<div class="col-sm-6">-->
                <!--    <ol class="breadcrumb float-sm-right">-->
                <!--        <li class="breadcrumb-item">-->
                <!--            <a href="{{url('/restaurant/home')}}">-->
                <!--                @lang('messages.control_panel')-->
                <!--            </a>-->
                <!--        </li>-->
                <!--        <li class="breadcrumb-item active">-->
                <!--            <a href="{{route('restaurant_our_rates')}}"></a>-->
                <!--            @lang('messages.our_rates')-->
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
                <div class="card">
                    <!-- /.card-header -->
                    <div class="card-body">
                        <table id="example1" class="table  table-striped">
                            <thead>
                            <tr>
                                <th> # ID </th>
                                <th>{{app()->getLocale() == 'ar' ?  'التاريخ': 'date'}}</th>
                                <th>{{app()->getLocale() == 'ar' ?  'التقييم': 'rate'}}</th>
                                <th>@lang('messages.operations')</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php $i=1 ?>
                            @foreach($rates as $rate)
                                <tr class="odd gradeX">
                                    <td> {{$i}} </td>
                                    <td> {{$rate->created_at->format('Y-m-d H:i:s')}} </td>
                                    <td>
                                        <a class="btn btn-info" href="{{route('show_restaurant_rate' , $rate->id)}}">
                                            <i class="fa fa-eye"></i>
                                           
                                        </a>
{{--                                        <button type="button" class="btn btn-primary" data-toggle="modal"--}}
{{--                                                data-target="#modal-default-{{$rate->id}}">--}}
{{--                                            <i class="fa fa-eye"></i>--}}
{{--                                            @lang('messages.show')--}}
{{--                                        </button>--}}
{{--                                        <div class="modal fade" id="modal-default-{{$rate->id}}">--}}
{{--                                            <div class="modal-dialog">--}}
{{--                                                <div class="modal-content bg-default">--}}
{{--                                                    <div class="modal-header">--}}
{{--                                                        <h4 class="modal-title">--}}
{{--                                                            عرض التقييم--}}
{{--                                                        </h4>--}}
{{--                                                        <button type="button" class="close" data-dismiss="modal"--}}
{{--                                                                aria-label="Close">--}}
{{--                                                            <span aria-hidden="true">&times;</span></button>--}}
{{--                                                    </div>--}}
{{--                                                    <div class="modal-body">--}}
{{--                                                        @foreach($rate->answers as $answer)--}}
{{--                                                            <p> {{app()->getLocale() == 'ar' ? $answer->rate->question_ar : $answer->rate->question_en}} </p>--}}
{{--                                                            <p> {{$answer->answer}} </p>--}}
{{--                                                        @endforeach--}}
{{--                                                    </div>--}}
{{--                                                    <div class="modal-footer justify-content-between">--}}
{{--                                                        <button type="button" class="btn btn-outline-light"--}}
{{--                                                                data-dismiss="modal">--}}
{{--                                                            @lang('messages.close')--}}
{{--                                                        </button>--}}
{{--                                                    </div>--}}
{{--                                                </div>--}}
{{--                                                <!-- /.modal-content -->--}}
{{--                                            </div>--}}
{{--                                            <!-- /.modal-dialog -->--}}
{{--                                        </div>--}}
                                    </td>
                                    <td>
                                        <a class="delete_data btn btn-danger" data="{{ $rate->id }}" data_name="" >
                                            <i class="fa fa-trash"></i>
                                        </a>
                                    </td>
                                </tr>
                                <?php $i++; ?>
                            @endforeach
                            </tbody>
                        </table>
                        {{$rates->links()}}
                    </div>
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
                    [10, 25, 50 , 100, -1],
                    [10, 25, 50,  100,'All'],
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
            var CSRF_TOKEN = $('meta[name="X-CSRF-TOKEN"]').attr('content');

            $('body').on('click', '.delete_data', function() {
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
                }, function() {

                    {{--var url = '{{ route("imageProductRemove", ":id") }}';--}}

                            {{--url = url.replace(':id', id);--}}

                        window.location.href = "{{ url('/') }}" + "/restaurant/restaurant_our_rates/delete/"+id;


                });

            });

        });
    </script>

@endsection
