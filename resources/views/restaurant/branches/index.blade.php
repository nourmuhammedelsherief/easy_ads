@extends('restaurant.lteLayout.master')

@section('title')
    @lang('messages.branches')
@endsection

@section('style')
    <link rel="stylesheet" href="{{asset('plugins/datatables-bs4/css/dataTables.bootstrap4.css')}}">
    <link rel="stylesheet" href="{{ URL::asset('admin/css/sweetalert.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('admin/css/sweetalert.css') }}">
    <!-- Theme style -->
    <style>
        #barcode-svg {
            width: 1000px;
        }
    </style>
@endsection

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>@lang('messages.branches')</h1>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>
    @include('flash::message')

    <section class="content">
        <div class="row">
            <div class="col-12">
                <h3>
                    <a href="{{route('branches.create')}}" class="btn">
                        <i class="fa fa-plus"></i>
                        @lang('messages.add_new')
                    </a>
                </h3>
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
                                <th> @lang('messages.name') </th>
                                {{--                                <th> @lang('messages.country') </th>--}}
                                <th> @lang('messages.city') </th>
                                <th> @lang('messages.barcode') </th>
                                {{--                                <th> @lang('messages.cart_show') </th>--}}
                                {{-- <th> {{app()->getLocale() == 'ar' ? 'ايقاف المنيو': 'stop menu'}} </th> --}}
                                <th> @lang('messages.operations') </th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php $i = 0 ?>
                            @foreach($branches as $branch)
                                <tr class="odd gradeX">
                                    <td>
                                        <label class="mt-checkbox mt-checkbox-single mt-checkbox-outline">
                                            <input type="checkbox" class="checkboxes" value="1"/>
                                            <span></span>
                                        </label>
                                    </td>
                                    <td><?php echo ++$i ?></td>
                                    <td>
                                        {{app()->getLocale() == 'ar' ? ($branch->name_ar == null ? $branch->name_en : $branch->name_ar) : ($branch->name_en == null ? $branch->name_ar : $branch->name_en)}}
                                    </td>
                                    <td>
                                        {{app()->getLocale() == 'ar' ? ($branch->city->name_ar == null ? $branch->city->name_en : $branch->city->name_ar) : ($branch->city->name_en == null ? $branch->city->name_ar : $branch->city->name_en)}}
                                    </td>
                                    <td>
                                        <a href="{{route('branchBarcode' , $branch->id)}}" class="btn btn-success"><i
                                                class="fa fa-eye"></i>@lang('messages.show')</a>
                                    </td>
                                    <td>
                                        <a class="btn btn-primary" href="{{route('branches.edit' , $branch->id)}}">
                                            <i class="fa fa-user-edit"></i>
                                        </a>
                                        <a class="delete_data btn btn-danger" data="{{ $branch->id }}"
                                           data_name="{{ app()->getLocale() == 'ar' ? ($branch->name_ar == null ? $branch->name_en : $branch->name_ar) : ($branch->name_en == null ? $branch->name_ar : $branch->name_en) }}">
                                            <i class="fa fa-trash"></i>
                                        </a>

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
    {!! $branches->withQueryString()->links('pagination::bootstrap-5') !!}
    <!-- /.row -->
    </section>
@endsection

@section('scripts')

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

                    window.location.href = "{{ url('/') }}" + "/console/branches/delete/" + id;

                });

            });
        });
    </script>

@endsection

