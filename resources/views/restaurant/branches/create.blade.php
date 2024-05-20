@extends('restaurant.lteLayout.master')

@section('title')
    @lang('messages.add') @lang('messages.branches')
@endsection
<style>
    #map {
        height: 600px;
        width: 1100px;
        position: relative;
        overflow: hidden;
    }
</style>

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1> @lang('messages.add') @lang('messages.branches') </h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">
                            <a href="{{url('/restaurant/home')}}">@lang('messages.control_panel')</a>
                        </li>
                        <li class="breadcrumb-item active">
                            <a href="{{route('branches.index')}}">
                                @lang('messages.branches')
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
                {{--                    <p style="color: red;">--}}
                {{--                        @php--}}
                {{--                            $period = \App\Models\Setting::first()->branch_service_tentative_period;--}}
                {{--                            $package_price = \App\Models\Package::first()->branch_price;--}}
                {{--                            $tax = ($package_price * \App\Models\Setting::first()->tax) / 100;--}}
                {{--                            $total = $package_price + $tax;--}}
                {{--                        @endphp--}}
                {{--                        @lang('messages.branch_tentative_details')--}}
                {{--                        {{$period}}--}}
                {{--                        @lang('messages.a_day')--}}
                {{--                        <br>--}}
                {{--                        @lang('messages.branch_price_after_tentative')--}}
                {{--                        {{number_format((float)$package_price, 2, '.', '')}}--}}
                {{--                        @lang('messages.SR')--}}
                {{--                        <br>--}}
                {{--                        @lang('messages.tax') :--}}
                {{--                        {{number_format((float)$tax, 2, '.', '')}}--}}
                {{--                        @lang('messages.SR')--}}
                {{--                        <br>--}}
                {{--                        @lang('messages.total') :--}}
                {{--                        {{number_format((float)$total, 2, '.', '')}}--}}
                {{--                        @lang('messages.SR')--}}
                {{--                    </p>--}}
                {{--                @include('flash::message')--}}
                <!-- general form elements -->
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">@lang('messages.add') @lang('messages.branches') </h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        <form role="form" action="{{route('branches.store')}}" method="post"
                              enctype="multipart/form-data">
                            <input type='hidden' name='_token' value='{{Session::token()}}'>

                            <div class="card-body">
                                {{--                                <div class="form-group">--}}
                                {{--                                    <label class="control-label"> @lang('messages.country') </label>--}}
                                {{--                                    <select name="country_id" class="form-control" required>--}}
                                {{--                                        <option disabled selected> @lang('messages.choose_one') </option>--}}
                                {{--                                        @foreach($countries as $country)--}}
                                {{--                                            <option value="{{$country->id}}">--}}
                                {{--                                                @if(app()->getLocale() == 'ar')--}}
                                {{--                                                    {{$country->name_ar}}--}}
                                {{--                                                @else--}}
                                {{--                                                    {{$country->name_en}}--}}
                                {{--                                                @endif--}}
                                {{--                                            </option>--}}
                                {{--                                        @endforeach--}}
                                {{--                                    </select>--}}
                                {{--                                    @if ($errors->has('country_id'))--}}
                                {{--                                        <span class="help-block">--}}
                                {{--                                            <strong style="color: red;">{{ $errors->first('country_id') }}</strong>--}}
                                {{--                                        </span>--}}
                                {{--                                    @endif--}}
                                {{--                                </div>--}}
                                <div class="form-group">
                                    <label class="control-label"> @lang('messages.city') </label>
                                    <select id="register_city" name="city_id" class="form-control" required>
                                        <option disabled selected> @lang('messages.choose_one') </option>
                                        @foreach($cities as $city)
                                            <option value="{{$city->id}}">
                                                {{app()->getLocale() == 'ar' ? $city->name_ar : $city->name_en }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('city_id'))
                                        <span class="help-block">
                                            <strong
                                                style="color: red;">{{ $errors->first('city_id') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label class="control-label"> @lang('messages.name_ar') </label>
                                    <input name="name_ar" type="text" class="form-control" value="{{old('name_ar')}}"
                                           placeholder="@lang('messages.name_ar')">
                                    @if ($errors->has('name_ar'))
                                        <span class="help-block">
                                            <strong style="color: red;">{{ $errors->first('name_ar') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label class="control-label"> @lang('messages.name_en') </label>
                                    <input name="name_en" onkeypress="clsAlphaNoOnly(event)" onpaste="return false;"
                                           type="text" class="form-control" value="{{old('name_en')}}"
                                           placeholder="@lang('messages.name_en') [format :  A-Za-z]" required>
                                    @if ($errors->has('name_en'))
                                        <span class="help-block">
                                            <strong style="color: red;">{{ $errors->first('name_en') }}</strong>
                                        </span>
                                    @endif
                                </div>

                                {{--                                <div class="form-group">--}}
                                {{--                                    <label class="control-label"> @lang('messages.name_barcode_branch') </label>--}}
                                {{--                                    <input name="name_barcode" type="text" class="form-control" value="{{old('name_barcode')}}" placeholder="@lang('messages.name_barcode_branch')">--}}
                                {{--                                    @if ($errors->has('name_barcode'))--}}
                                {{--                                        <span class="help-block">--}}
                                {{--                                            <strong style="color: red;">{{ $errors->first('name_barcode') }}</strong>--}}
                                {{--                                        </span>--}}
                                {{--                                    @endif--}}
                                {{--                                </div>--}}

                                <div class="form-group">
                                    <label class="control-label"> @lang('messages.branch_location') </label>
                                    <h4 style="text-align: right">  @lang('messages.selectPosition')  </h4>
                                    <input type="text" id="lat" name="latitude" readonly="yes" required/>
                                    <input type="text" id="lng" name="longitude" readonly="yes" required/>
                                    <a class="btn btn-info" onclick="getLocation()"> @lang('messages.MyPosition') </a>
                                    @if ($errors->has('latitude'))
                                        <span class="help-block">
                                            <strong style="color: red;">{{ $errors->first('latitude') }}</strong>
                                        </span>
                                    @endif
                                    <hr>
                                    <div id="map" style="position: relative; height: 600px; width: 600px; "></div>
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
{{--    <script>--}}
{{--        $(document).ready(function () {--}}
{{--            $('select[name="country_id"]').on('change', function () {--}}
{{--                var id = $(this).val();--}}
{{--                $.ajax({--}}
{{--                    url: '/get/cities/' + id,--}}
{{--                    type: "GET",--}}
{{--                    dataType: "json",--}}
{{--                    success: function (data) {--}}
{{--                        console.log(data);--}}
{{--                        $('#register_city').empty();--}}
{{--                        // $('select[name="city_id"]').append("<option disabled selected> choose </option>");--}}
{{--                        // $('select[name="city"]').append('<option value>المدينة</option>');--}}
{{--                        $('select[name="city_id"]').append("<option disabled selected> @lang('messages.choose_one') </option>");--}}
{{--                        $.each(data, function (index, cities) {--}}
{{--                            console.log(cities);--}}
{{--                            @if(app()->getLocale() == 'ar')--}}
{{--                            $('select[name="city_id"]').append('<option value="' + cities.id + '">' + cities.name_ar + '</option>');--}}
{{--                            @else--}}
{{--                            $('select[name="city_id"]').append('<option value="' + cities.id + '">' + cities.name_en + '</option>');--}}
{{--                            @endif--}}
{{--                        });--}}
{{--                    }--}}
{{--                });--}}
{{--            });--}}
{{--        });--}}
{{--    </script>--}}

    <script>
        function clsAlphaNoOnly(e) {  // Accept only alpha numerics, no special characters
            var regex = new RegExp("^[a-zA-Z0-9 ]+$");
            var str = String.fromCharCode(!e.charCode ? e.which : e.charCode);
            if (regex.test(str)) {
                return true;
            }

            e.preventDefault();
            return false;
        }

        function clsAlphaNoOnly2() {  // Accept only alpha numerics, no special characters
            return clsAlphaNoOnly(this.event); // window.event
        }
    </script>
    <script>
        $(document).ready(function () {
            $(document).on('submit', 'form', function () {
                $('button').attr('disabled', 'disabled');
            });
        });
    </script>
    <script>
        function getLocation() {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(showPosition);
            } else {
                x.innerHTML = "Geolocation is not supported by this browser.";
            }
        }

        function showPosition(position) {
            lat = position.coords.latitude;
            lon = position.coords.longitude;

            document.getElementById('lat').value = lat; //latitude
            document.getElementById('lng').value = lon; //longitude
            latlon = new google.maps.LatLng(lat, lon)
            mapholder = document.getElementById('mapholder')
            //mapholder.style.height='250px';
            //mapholder.style.width='100%';

            var myOptions = {
                center: latlon,
                zoom: 14,
                mapTypeId: google.maps.MapTypeId.ROADMAP,
                mapTypeControl: false,
                navigationControlOptions: {
                    style: google.maps.NavigationControlStyle.SMALL
                }
            };
            var map = new google.maps.Map(document.getElementById("map"), myOptions);
            var marker = new google.maps.Marker({
                position: latlon,
                map: map,
                title: "You are here!"
            });
            //Listen for any clicks on the map.
            google.maps.event.addListener(map, 'click', function (event) {
                //Get the location that the user clicked.
                var clickedLocation = event.latLng;
                //If the marker hasn't been added.
                if (marker === false) {
                    //Create the marker.
                    marker = new google.maps.Marker({
                        position: clickedLocation,
                        map: map,
                        draggable: true //make it draggable
                    });
                    //Listen for drag events!
                    google.maps.event.addListener(marker, 'dragend', function (event) {
                        markerLocation();
                    });
                } else {
                    //Marker has already been added, so just change its location.
                    marker.setPosition(clickedLocation);
                }
                //Get the marker's location.
                markerLocation();
            });


            function markerLocation() {
                //Get location.
                var currentLocation = marker.getPosition();
                //Add lat and lng values to a field that we can save.
                document.getElementById('lat').value = currentLocation.lat(); //latitude
                document.getElementById('lng').value = currentLocation.lng(); //longitude
            }
        }

        function previousYesNoCheck() {
            if (document.getElementById('previousYes').checked) {
                document.getElementById('previous_periods').style.display = 'block';
            } else {
                document.getElementById('previous_periods').style.display = 'none';
            }
        }
    </script>

    <script type="text/javascript">
        var map;

        function initMap() {

            var latitude = 24.5; // YOUR LATITUDE VALUE
            var longitude = 46.7; // YOUR LONGITUDE VALUE

            var myLatLng = {
                lat: latitude,
                lng: longitude
            };

            map = new google.maps.Map(document.getElementById('map'), {
                center: myLatLng,
                zoom: 5,
                gestureHandling: 'true',
                zoomControl: false // disable the default map zoom on double click
            });


            var marker = new google.maps.Marker({
                position: myLatLng,
                map: map,
                //title: 'Hello World'
                // setting latitude & longitude as title of the marker
                // title is shown when you hover over the marker
                title: latitude + ', ' + longitude
            });


            //         //Listen for any clicks on the map.
            google.maps.event.addListener(map, 'click', function (event) {
                //Get the location that the user clicked.
                var clickedLocation = event.latLng;
                //If the marker hasn't been added.
                if (marker === false) {
                    //Create the marker.
                    marker = new google.maps.Marker({
                        position: clickedLocation,
                        map: map,
                        draggable: true //make it draggable
                    });
                    //Listen for drag events!
                    google.maps.event.addListener(marker, 'dragend', function (event) {
                        markerLocation();
                    });
                } else {
                    //Marker has already been added, so just change its location.
                    marker.setPosition(clickedLocation);
                }
                //Get the marker's location.
                markerLocation();
            });


            function markerLocation() {
                //Get location.
                var currentLocation = marker.getPosition();
                //Add lat and lng values to a field that we can save.
                document.getElementById('lat').value = currentLocation.lat(); //latitude
                document.getElementById('lng').value = currentLocation.lng(); //longitude
            }
        }
    </script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAFUMq5htfgLMNYvN4cuHvfGmhe8AwBeKU&callback=initMap"
            async
            defer></script>
@endsection
