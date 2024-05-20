@extends('admin.lteLayout.master')
@section('title')
    @lang('messages.restaurants')
    @if ($status == 'active')
        @lang('messages.active_restaurants')
    @elseif($status == 'finished')
        @lang('messages.finished_restaurants')
    @elseif($status == 'new')
        @lang('messages.new_restaurants')
    @elseif($status == 'free')
        @lang('messages.free_restaurants')
    @endif
@endsection

@section('style')
    <link rel="stylesheet" href="{{ asset('plugins/datatables-bs4/css/dataTables.bootstrap4.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('admin/css/sweetalert.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('admin/css/sweetalert.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <style>
        .dropbtn {
            background-color: #04AA6D;
            color: white;
            padding: 10px;
            font-size: 10px;
            border: none;
        }

        .dropdown {
            position: relative;
            display: inline-block;
        }

        .dropdown-content {
            display: none;
            position: absolute;
            background-color: #f1f1f1;
            min-width: 100px;
            box-shadow: 0px 8px 16px 0px rgba(0, 0, 0, 0.2);
            z-index: 1;
        }

        .dropdown-content a {
            color: black;
            padding: 2px 3px;
            text-decoration: none;
            font-size: 10px;
            display: block;
        }

        .dropdown-content a:hover {
            background-color: #ddd;
        }

        .dropdown:hover .dropdown-content {
            display: block;
        }

        .dropdown:hover .dropbtn {
            background-color: #3e8e41;
        }

        #example1_wrapper {
            overflow: auto;
        }

        .archive.btn {
            margin-bottom: 10px;
        }

        .archive.btn.archiveActive {
            background-color: #007bff;
            border-color: #007bff;
        }

        .control_progress {
            display: flex;
            flex-direction: row;
            flex-wrap: wrap;
            list-style: none;
        }

        .login_res {
            transition: all 0.3s linear;
            position: relative;
        }

        .login_res i {
            color: white !important;
        }

        .show_text {
            display: none;
            position: absolute;
            right: 0;
            z-index: 9999;
            background-color: #eeeeee;
            padding: 2px;

        }

        .login_res:hover .show_text {
            display: block;
        }
    </style>
@endsection

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>@lang('messages.restaurants')
                        @if ($status == 'active')
                            @lang('messages.active_restaurants')
                        @elseif($status == 'finished')
                            @lang('messages.finished_restaurants')
                        @elseif($status == 'new')
                            @lang('messages.new_restaurants')
                        @elseif($status == 'free')
                            @lang('messages.free_restaurants')
                        @endif
                    </h1>
                </div>
            </div>
        </div>
    </section>
    @include('flash::message')
    <section class="content">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <!-- /.card-header -->
                    <div class="card-body">
                        <table id="example1" class="table table-striped" style="overflow: auto;">
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
                                <th>@lang('messages.restaurant')</th>
                                <th>@lang('messages.products')</th>
                                <th> @lang('messages.branches') </th>
                                <th> @lang('messages.clients') </th>
                                <th> @lang('messages.payment_type') </th>
                                <th>@lang('messages.operations')</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php $i = 0; ?>
                            @php
                                $now = Carbon\Carbon::parse(date('Y-m-d'));
                            @endphp
                            @foreach ($restaurants as $restaurant)
                                <?php $restaurant = $restaurant->restaurant; ?>
                                <tr class="odd gradeX">
                                    <td>
                                        <label class="mt-checkbox mt-checkbox-single mt-checkbox-outline">
                                            <input type="checkbox" class="checkboxes" value="1"/>
                                            <span></span>
                                        </label>
                                    </td>
                                    <td><?php echo ++$i; ?></td>
                                    <td>
                                        @if (app()->getLocale() == 'ar')
                                            {{ $restaurant->name_ar }}
                                        @else
                                            {{ $restaurant->name_en }}
                                        @endif
                                    </td>
                                    <td>
                                        @php
                                            $country = $restaurant->country->code;
                                            $check = substr($restaurant->phone_number, 0, 2) === '05';
                                            if ($check == true) {
                                                $phone = $country . ltrim($restaurant->phone_number, '0');
                                            } else {
                                                $phone = $country . $restaurant->phone_number;
                                            }
                                        @endphp
                                        @if ($restaurant->phone_number != null)
                                            <a target="_blank"
                                               href="https://api.whatsapp.com/send?phone={{ $phone }}">
                                                <i style="font-size:24px" class="fa">&#xf232;</i>
                                            </a>
                                            <a href="tel:{{ $phone }}">
                                                <i class="fa fa-phone"></i>
                                            </a>
                                        @endif
                                    </td>
                                    <td>
                                        @if ($restaurant->country != null)
                                            @if (app()->getLocale() == 'ar')
                                                {{ $restaurant->country->name_ar }}
                                            @else
                                                {{ $restaurant->country->name_en }}
                                            @endif
                                        @endif
                                    </td>
                                    <td>
                                        <a target="_blank" href="{{url('/restaurants/' . $restaurant->name_barcode)}}">
                                            <i class="fa fa-eye"></i>
                                        </a>
                                    </td>
                                    <td>
                                        {{$restaurant->products->count()}}
                                    </td>
                                    <td>
                                        {{$restaurant->branches->count()}}
                                    </td>
                                    <td>
                                        <a href="{{route('AzRestaurantUsers' , $restaurant->id)}}" class="btn btn-success">
                                            {{$restaurant->users->count()}}
                                        </a>
                                    </td>
                                    <td>
                                        @if($restaurant->a_z_orders_payment_type == 'myFatoourah')
                                            @lang('messages.myFatoourah')
                                        @elseif($restaurant->a_z_orders_payment_type == 'tap')
                                            @lang('messages.tap')
                                        @elseif($restaurant->a_z_orders_payment_type == 'edfa')
                                            @lang('messages.edfa')
                                        @endif
                                    </td>
                                    <td class="control_progress">
                                        <!--<div class="dropdown">-->
                                        <!--    <button type="button" class="btn btn-primary dropbtn"-->
                                        <!--        data-toggle="dropdown">-->
                                    <!--        @lang('messages.operations')-->
                                        <!--        <span class="caret"></span></button>-->
                                        <!--<div class="dropdown-content">-->


                                        <!--start login_res-->

                                        <li class="login_res">
                                            <a class="btn btn-warning" target="__blank"
                                               href="{{ route('admin.restaurant.login', [$restaurant->id, 'false']) }}">
                                                <i class="fa fa-user"></i>

                                            </a>
                                            <span class="show_text">
                                                @lang('messages.login_to_restaurant')
                                            </span>
                                        </li>
                                        <li class="login_res">
                                            <a class="btn btn-primary"
                                               href="{{ route('editRestaurant', $restaurant->id) }}">
                                                <i class="fa fa-edit"></i>
                                            </a>
                                            <span class="show_text">
                                                @lang('messages.restaurant_settings')
                                            </span>
                                        </li>
                                        <li class="login_res">
                                            <a class="btn btn-info"
                                               href="{{ route('AzRestaurantCommissions', $restaurant->id) }}">
                                                <i class="fa fa-eye"></i>
                                            </a>
                                            <span class="show_text">
                                                @lang('messages.commission_system')
                                            </span>
                                        </li>
                                        <!--</div>-->
                                        <!--</div>-->

                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        {!! $restaurants->withQueryString()->links('pagination::bootstrap-5') !!}
                    </div>
                    <!-- /.card-body -->
                </div>
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </section>
    <!-- Modal -->
@endsection

@section('scripts')
    {{--    <script src="{{asset('dist/js/adminlte.min.js')}}"></script> --}}
    <script src="{{ asset('plugins/datatables/jquery.dataTables.js') }}"></script>
    <script src="{{ asset('plugins/datatables-bs4/js/dataTables.bootstrap4.js') }}"></script>
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

                    {{-- var url = '{{ route("imageProductRemove", ":id") }}'; --}}

                        {{-- url = url.replace(':id', id); --}}

                        window.location.href = "{{ url('/') }}" + "/admin/restaurants/delete/" +
                        id;
                });
            });
            $('#formArchive').on('change', 'select', function () {
                var tag = $(this);
                if (tag.val() == -1) {
                    $('.archive_reason').fadeIn(300);
                } else {
                    $('.archive_reason').fadeOut(50);
                }
            });
            $('table').on('click', '.btn-archive', function () {
                var tag = $(this);
                console.log(tag.data('href'));
                $('#formArchive form').attr('action', tag.data('href'));
                $('#formArchive select').val('');
                $('#formArchive select').trigger('change');
            });
        });
    </script>
@endsection
<style>

    .content .btn_archive {
        color: white !important;
        background-color: #64748b !important;
        width: max-content;
        border-radius: 5px;
        font-family: 'cairo';

    }
</style>
