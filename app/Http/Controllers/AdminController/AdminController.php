<?php

namespace App\Http\Controllers\AdminController;

use App\Http\Controllers\Controller;
use App\Models\Branch;
use App\Models\Category;
use App\Models\City;
use App\Models\Country;
use App\Models\History;
use App\Models\Report;
use App\Models\Restaurant;
use App\Models\ServiceSubscription;
use App\Models\Subscription;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $year = $request->year == null ? Carbon::now()->format('Y') : $request->year;
        $month = $request->month == null ? Carbon::now()->format('m') : $request->month;

        if ($month == 'all')
        {
            $registered_restaurants = Restaurant::whereyear('created_at','=',$year)
                ->whereType('restaurant')
                ->count();
            $month_subscription = Report::whereType('restaurant')
                ->whereStatus('subscribed')
                ->whereyear('created_at','=',$year)
                ->count();
            $pre_month_subscription = Report::whereType('restaurant')
                ->whereStatus('subscribed')
                ->whereyear('created_at','<',$year)
                ->count();
//
            $restaurants_not_subscribed = Restaurant::whereIn('status' , ['tentative' , 'tentative_finished' , 'inComplete'])
                ->whereyear('created_at','=',$year)
                ->whereType('restaurant')
                ->count();

            $renewed_restaurants = Report::whereType('restaurant')
                ->whereStatus('renewed')
                ->whereyear('created_at','=',$year)
                ->count();
            $need_renew_restaurants = Restaurant::with('subscription')
                ->whereHas('subscription', function ($q) use ($year, $month) {
                    $q->whereyear('end_at','=',$year);
                    $q->whereIn('status', ['active' , 'finished']);
                    $q->where('type', 'restaurant');
                })
                ->count();
            $restaurants_not_renewed = Restaurant::with('subscription')
                ->whereHas('subscription', function ($q) use ($year, $month) {
                    $q->whereyear('end_at','=',$year);
                    $q->where('status', 'finished');
                    $q->where('type', 'restaurant');
                })
                ->count();
            $total_renewed_restaurants = $renewed_restaurants + $need_renew_restaurants;
            // services
            $registered_services = Report::whereType('service')
                ->where('status', 'subscribed')
                ->whereyear('created_at','=',$year)
                ->count();

            $renew_services = Report::whereType('service')
                ->where('status', 'renewed')
                ->whereyear('created_at','=',$year)
                ->count();
            $services_not_renewed = ServiceSubscription::whereyear('end_at','=',$year)
                ->whereIn('service_id', [1, 4, 9,10])
                ->whereStatus('finished')
                ->count();
            $required_renew_services = $renew_services + $services_not_renewed;

            // branches
            $subscribed_branches = Report::whereType('branch')
                ->whereStatus('subscribed')
                ->whereyear('created_at','=',$year)
                ->count();
            $branches_not_renewed = Branch::with('subscription')
                ->whereHas('subscription', function ($q) use ($year, $month) {
                    $q->whereyear('end_at','=',$year);
                    $q->where('status', 'active');
                    $q->where('type', 'finished');
                })
                ->count();
            $renewed_branches = Report::whereType('branch')
                ->whereStatus('renewed')
                ->whereyear('created_at','=',$year)
                ->count();
            $branches_renew_subscription = $branches_not_renewed + $renewed_branches;

            // sum amounts
            $subscription = Report::whereType('restaurant')
                ->whereStatus('subscribed')
                ->whereyear('created_at','=',$year)
                ->distinct()
                ->sum('amount');
            $renew = Report::whereType('restaurant')
                ->whereStatus('renewed')
                ->whereyear('created_at','=',$year)
                ->sum('amount');
            $services_amount = Report::whereType('service')
                ->where('status', 'subscribed')
                ->whereyear('created_at','=',$year)
                ->sum('amount');
            $services_renew_amount = Report::whereType('service')
                ->where('status', 'renewed')
                ->whereyear('created_at','=',$year)
                ->sum('amount');
            $subscribed_branches_amount = Report::whereType('branch')
                ->whereStatus('subscribed')
                ->whereyear('created_at','=',$year)
                ->sum('amount');
            $renewed_branches_amount = Report::whereType('branch')
                ->whereStatus('renewed')
                ->whereyear('created_at','=',$year)
                ->sum('amount');
            $month_total_amount = $subscription + $renew + $services_amount + $renewed_branches_amount + $subscribed_branches_amount + $services_renew_amount;
            $month_total_taxes = Report::whereyear('created_at','=',$year)
                ->whereIn('status' , ['subscribed' , 'renewed'])
                ->sum('tax_value');
        }else{
            $registered_restaurants = Restaurant::whereyear('created_at','=',$year)
                ->whereMonth('created_at','=',$month)
                ->whereType('restaurant')
                ->count();

            $month_subscription = Report::with('restaurant')
                ->whereHas('restaurant' , function ($q) use ($year , $month){
                    $q->whereyear('created_at','=',$year);
                    $q->whereMonth('created_at','=',$month);
                })
                ->whereType('restaurant')
                ->whereStatus('subscribed')
                ->count();

            $pre_month_subscription = Report::with('restaurant')
                ->whereHas('restaurant' , function ($q) use ($year , $month){
                    $q->whereyear('created_at','=', $year);
                    $q->whereMonth('created_at','<', $month);
                })
                ->whereType('restaurant')
                ->whereStatus('subscribed')
                ->whereyear('created_at','=',$year)
                ->whereMonth('created_at','=',$month)
                ->count();
//
            $restaurants_not_subscribed = Restaurant::whereIn('status' , ['tentative' , 'tentative_finished' , 'inComplete'])
                ->whereyear('created_at','=',$year)
                ->whereMonth('created_at','=',$month)
                ->whereType('restaurant')
                ->count();

            //////////////////////////

            $renewed_restaurants = Report::whereType('restaurant')
                ->whereStatus('renewed')
                ->whereyear('created_at','=',$year)
                ->whereMonth('created_at','=',$month)
                ->count();
            $need_renew_restaurants = Restaurant::with('subscription')
                ->whereHas('subscription', function ($q) use ($year, $month) {
                    $q->whereyear('end_at','=',$year);
                    $q->whereMonth('end_at','=',$month);
                    $q->whereIn('status', ['active' , 'finished']);
                    $q->where('type', 'restaurant');
                })
                ->count();
            $restaurants_not_renewed = Restaurant::with('subscription')
                ->whereHas('subscription', function ($q) use ($year, $month) {
                    $q->whereyear('end_at','=',$year);
                    $q->whereMonth('end_at','=',$month);
                    $q->where('status', 'finished');
                    $q->where('type', 'restaurant');
                })
                ->count();
            $total_renewed_restaurants = $renewed_restaurants + $need_renew_restaurants;
            // services
            $registered_services = Report::whereType('service')
                ->where('status', 'subscribed')
                ->whereyear('created_at','=',$year)
                ->whereMonth('created_at','=',$month)
                ->count();

            $renew_services = Report::whereType('service')
                ->where('status', 'renewed')
                ->whereyear('created_at','=',$year)
                ->whereMonth('created_at','=',$month)
                ->count();
            $services_not_renewed = ServiceSubscription::whereyear('end_at','=',$year)
                ->whereMonth('end_at','=',$month)
                ->whereIn('service_id', [1, 4, 9,10])
                ->whereStatus('finished')
                ->count();
            $required_renew_services = $renew_services + $services_not_renewed;

            // branches
            $subscribed_branches = Report::whereType('branch')
                ->whereStatus('subscribed')
                ->whereyear('created_at','=',$year)
                ->whereMonth('created_at','=',$month)
                ->count();
//        $branches_renew_subscription = Branch::with('subscription')
//            ->whereHas('subscription', function ($q) use ($year, $month) {
//                $q->whereyear('end_at','=',$year);
//                $q->whereMonth('end_at','=',$month);
//                $q->where('status', 'active');
//                $q->where('type', 'branch');
//            })
//            ->count();
            $branches_not_renewed = Branch::with('subscription')
                ->whereHas('subscription', function ($q) use ($year, $month) {
                    $q->whereyear('end_at','=',$year);
                    $q->whereMonth('end_at','=',$month);
                    $q->where('status', 'active');
                    $q->where('type', 'finished');
                })
                ->count();
            $renewed_branches = Report::whereType('branch')
                ->whereStatus('renewed')
                ->whereyear('created_at','=',$year)
                ->whereMonth('created_at','=',$month)
                ->count();
            $branches_renew_subscription = $branches_not_renewed + $renewed_branches;

            // sum amounts
            $subscription = Report::whereType('restaurant')
                ->whereStatus('subscribed')
                ->whereyear('created_at','=',$year)
                ->whereMonth('created_at','=',$month)
                ->sum('amount');
            $renew = Report::whereType('restaurant')
                ->whereStatus('renewed')
                ->whereyear('created_at','=',$year)
                ->whereMonth('created_at','=',$month)
                ->sum('amount');
            $services_amount = Report::whereType('service')
                ->where('status', 'subscribed')
                ->whereyear('created_at','=',$year)
                ->whereMonth('created_at','=',$month)
                ->sum('amount');
            $services_renew_amount = Report::whereType('service')
                ->where('status', 'renewed')
                ->whereyear('created_at','=',$year)
                ->whereMonth('created_at','=',$month)
                ->sum('amount');
            $subscribed_branches_amount = Report::whereType('branch')
                ->whereStatus('subscribed')
                ->whereyear('created_at','=',$year)
                ->whereMonth('created_at','=',$month)
                ->sum('amount');
            $renewed_branches_amount = Report::whereType('branch')
                ->whereStatus('renewed')
                ->whereyear('created_at','=',$year)
                ->whereMonth('created_at','=',$month)
                ->sum('amount');
            $month_total_amount = $subscription + $renew + $services_amount + $renewed_branches_amount + $subscribed_branches_amount + $services_renew_amount;
            $month_total_taxes = Report::whereyear('created_at','=',$year)
                ->whereMonth('created_at','=',$month)
                ->whereIn('status' , ['subscribed' , 'renewed'])
                ->sum('tax_value');
        }
        return view('admin.reports.index', compact('registered_restaurants','total_renewed_restaurants','restaurants_not_subscribed','month_subscription','pre_month_subscription' ,'month_total_taxes','branches_not_renewed', 'services_not_renewed','restaurants_not_renewed', 'month_total_amount', 'renewed_branches_amount', 'branches_renew_subscription', 'renewed_branches', 'subscribed_branches_amount', 'subscribed_branches', 'need_renew_restaurants', 'required_renew_services', 'services_renew_amount', 'services_amount', 'renew', 'subscription', 'renew_services', 'registered_services', 'renewed_restaurants', 'year', 'month'));
    }

    public function restaurants($year, $month, $type)
    {
        if ($month == 'all')
        {
            if ($type == 'registered') {
                $restaurants = Restaurant::whereyear('created_at','=',$year)
                    ->whereType('restaurant')
                    ->get();
            } elseif ($type == 'subscribed') {
                $restaurants = Restaurant::with('reports')
                    ->whereHas('reports', function ($q) use ($year, $month) {
                        $q->whereType('restaurant');
                        $q->whereStatus('subscribed');
                    })
                    ->whereyear('created_at','=',$year)
                    ->get();
            }elseif ($type == 'pre_month_subscribed') {
                $restaurants = Restaurant::with('reports')
                    ->whereHas('reports', function ($q) use ($year, $month) {
                        $q->whereType('restaurant');
                        $q->whereStatus('subscribed');
                        $q->whereyear('created_at','=',$year);
                    })
                    ->whereyear('created_at','=',$year)
                    ->get();
            }
            elseif ($type == 'end') {
                $restaurants = Restaurant::with('subscription')
                    ->whereHas('subscription', function ($q) use ($year, $month) {
                        $q->whereyear('end_at','=',$year);
                        $q->whereIn('status', ['active' , 'finished']);
                        $q->where('type', 'restaurant');
                    })
                    ->get();
            } elseif ($type == 'renewed') {
                $restaurants = Restaurant::with('reports')
                    ->whereHas('reports', function ($q) use ($year, $month) {
                        $q->whereType('restaurant');
                        $q->whereStatus('renewed');
                        $q->whereyear('created_at','=',$year);
                    })
                    ->get();
            } elseif ($type == 'notSubscribed') {
                $restaurants = Restaurant::whereIn('status' , ['tentative' , 'tentative_finished' , 'inComplete'])
                    ->whereyear('created_at','=',$year)
                    ->get();
            }elseif ($type == 'finished')
            {
                $restaurants = Restaurant::with('subscription')
                    ->whereHas('subscription', function ($q) use ($year, $month) {
                        $q->whereyear('end_at','=',$year);
                        $q->where('status', 'finished');
                        $q->where('type', 'restaurant');
                    })
                    ->get();
            }
        }else{
            if ($type == 'registered') {
                $restaurants = Restaurant::whereyear('created_at','=',$year)
                    ->whereMonth('created_at','=',$month)
                    ->whereType('restaurant')
                    ->get();
            } elseif ($type == 'subscribed') {
                $restaurants = Restaurant::with('reports')
                    ->whereHas('reports', function ($q) use ($year, $month) {
                        $q->whereType('restaurant');
                        $q->whereStatus('subscribed');
                    })
                    ->whereyear('created_at','=',$year)
                    ->whereMonth('created_at','=',$month)
                    ->get();
            }elseif ($type == 'pre_month_subscribed') {
                $restaurants = Restaurant::with('reports')
                    ->whereHas('reports', function ($q) use ($year, $month) {
                        $q->whereType('restaurant');
                        $q->whereStatus('subscribed');
                        $q->whereyear('created_at','=',$year);
                        $q->whereMonth('created_at','=',$month );
                    })
                    ->whereyear('created_at','=',$year)
                    ->whereMonth('created_at','<',$month )
                    ->get();
            }
            elseif ($type == 'end') {
                $restaurants = Restaurant::with('subscription')
                    ->whereHas('subscription', function ($q) use ($year, $month) {
                        $q->whereyear('end_at','=',$year);
                        $q->whereMonth('end_at','=',$month);
                        $q->whereIn('status', ['active' , 'finished']);
                        $q->where('type', 'restaurant');
                    })
                    ->get();
            } elseif ($type == 'renewed') {
                $restaurants = Restaurant::with('reports')
                    ->whereHas('reports', function ($q) use ($year, $month) {
                        $q->whereType('restaurant');
                        $q->whereStatus('renewed');
                        $q->whereyear('created_at','=',$year);
                        $q->whereMonth('created_at','=',$month);
                    })
                    ->get();
            } elseif ($type == 'notSubscribed') {
                $restaurants = Restaurant::whereIn('status' , ['tentative' , 'tentative_finished' , 'inComplete'])
                    ->whereyear('created_at','=',$year)
                    ->whereMonth('created_at','=',$month)
                    ->get();
            }elseif ($type == 'finished')
            {
                $restaurants = Restaurant::with('subscription')
                    ->whereHas('subscription', function ($q) use ($year, $month) {
                        $q->whereyear('end_at','=',$year);
                        $q->whereMonth('end_at','=',$month);
                        $q->where('status', 'finished');
                        $q->where('type', 'restaurant');
                    })
                    ->get();
            }
        }
        $country = Country::first();
        return view('admin.countries.restaurants', compact('country', 'restaurants'));
    }

    public function services($year, $month, $type)
    {
        if ($month == 'all')
        {
            if ($type == 'sold') {
                $services = ServiceSubscription::with('reports')
                    ->whereHas('reports', function ($q) use ($year, $month) {
                        $q->whereType('service');
                        $q->whereStatus('subscribed');
                        $q->whereyear('created_at','=',$year);
                    })
                    ->get();
            }
            elseif ($type == 'renew') {
                $services = ServiceSubscription::with('reports')
                    ->whereHas('reports', function ($q) use ($year, $month) {
                        $q->whereType('service');
                        $q->whereStatus('renewed');
                        $q->whereyear('created_at','=',$year);
                    })
                    ->get();
            }
            elseif ($type == 'end') {
                $services = ServiceSubscription::whereyear('end_at','=',$year)
                    ->whereIn('service_id', [1, 4, 9,10])
                    ->whereStatus('active')
                    ->get();
            }
            elseif ($type == 'finished')
            {
                $services = ServiceSubscription::whereyear('end_at','=',$year)
                    ->whereIn('service_id', [1, 4,9,10])
                    ->whereStatus('finished')
                    ->get();
            }
        }else{
            if ($type == 'sold') {
                $services = ServiceSubscription::with('reports')
                    ->whereHas('reports', function ($q) use ($year, $month) {
                        $q->whereType('service');
                        $q->whereStatus('subscribed');
                        $q->whereyear('created_at','=',$year);
                        $q->whereMonth('created_at','=',$month);
                    })
                    ->get();
            }
            elseif ($type == 'renew') {
                $services = ServiceSubscription::with('reports')
                    ->whereHas('reports', function ($q) use ($year, $month) {
                        $q->whereType('service');
                        $q->whereStatus('renewed');
                        $q->whereyear('created_at','=',$year);
                        $q->whereMonth('created_at','=',$month);
                    })
                    ->get();
            }
            elseif ($type == 'end') {
                $services = ServiceSubscription::whereyear('end_at','=',$year)
                    ->whereMonth('end_at','=',$month)
                    ->whereIn('service_id', [1, 4, 9,10])
                    ->whereStatus('active')
                    ->get();
            }
            elseif ($type == 'finished')
            {
                $services = ServiceSubscription::whereyear('end_at','=',$year)
                    ->whereMonth('end_at','=',$month)
                    ->whereIn('service_id', [1, 4,9,10])
                    ->whereStatus('finished')
                    ->get();
            }
        }
        return view('admin.reports.services', compact('services', 'year', 'month', 'type'));
    }

    public function branches($year, $month, $type)
    {
        if ($month == 'all')
        {
            if ($type == 'subscribed') {
                $branches = Branch::with('reports')
                    ->whereHas('reports', function ($q) use ($year, $month) {
                        $q->whereType('branch');
                        $q->whereStatus('subscribed');
                        $q->whereyear('created_at','=',$year);
                    })
                    ->get();
            }
            elseif ($type == 'renewed') {
                $branches = Branch::with('reports')
                    ->whereHas('reports', function ($q) use ($year, $month) {
                        $q->whereType('branch');
                        $q->whereStatus('renewed');
                        $q->whereyear('created_at','=',$year);
                    })
                    ->get();
            }
            elseif ($type == 'required_renew') {
                $branches = Branch::with('subscription')
                    ->whereHas('subscription', function ($q) use ($year, $month) {
                        $q->whereyear('end_at','=',$year);
                        $q->where('status', 'active');
                        $q->where('type', 'branch');
                    })
                    ->get();
            }
            elseif ($type == 'not_renew')
            {
                $branches = Branch::with('subscription')
                    ->whereHas('subscription', function ($q) use ($year, $month) {
                        $q->whereyear('end_at','=',$year);
                        $q->where('status', 'finished');
                        $q->where('type', 'branch');
                    })
                    ->get();
            }
        }else{
            if ($type == 'subscribed') {
                $branches = Branch::with('reports')
                    ->whereHas('reports', function ($q) use ($year, $month) {
                        $q->whereType('branch');
                        $q->whereStatus('subscribed');
                        $q->whereyear('created_at','=',$year);
                        $q->whereMonth('created_at','=',$month);
                    })
                    ->get();
            }
            elseif ($type == 'renewed') {
                $branches = Branch::with('reports')
                    ->whereHas('reports', function ($q) use ($year, $month) {
                        $q->whereType('branch');
                        $q->whereStatus('renewed');
                        $q->whereyear('created_at','=',$year);
                        $q->whereMonth('created_at','=',$month);
                    })
                    ->get();
            }
            elseif ($type == 'required_renew') {
                $branches = Branch::with('subscription')
                    ->whereHas('subscription', function ($q) use ($year, $month) {
                        $q->whereyear('end_at','=',$year);
                        $q->whereMonth('end_at','=',$month);
                        $q->where('status', 'active');
                        $q->where('type', 'branch');
                    })
                    ->get();
            }
            elseif ($type == 'not_renew')
            {
                $branches = Branch::with('subscription')
                    ->whereHas('subscription', function ($q) use ($year, $month) {
                        $q->whereyear('end_at','=',$year);
                        $q->whereMonth('end_at','=',$month);
                        $q->where('status', 'finished');
                        $q->where('type', 'branch');
                    })
                    ->get();
            }
        }
        return view('admin.reports.branches', compact('branches', 'year', 'month', 'type'));
    }

    /**
     * @get countries and cities reports
     *
     */
    public function city_reports()
    {
        $countries = Country::all();
        return view('admin.reports.countries' , compact('countries'));
    }
    public function countries_cities($id)
    {
        $country = Country::find($id);
        $cities = City::whereCountryId($id)->get();
        return view('admin.reports.countries_cities' , compact('cities' , 'country'));
    }

    public function clients($city , $restaurantId = null)
    {
        $city = City::findOrFail($city);
        if($restaurantId  > 0){
            $restaurant = Restaurant::find($restaurantId);
            $clients = User::where( 'register_restaurant_id' ,$restaurantId)->where('city_id' , $city->id)->with('city' , 'country' , 'registerRestaurant')->paginate(500);
        }else{
            $restaurant = null;
            $clients = User::where('city_id' , $city->id)->with('city' , 'country' , 'registerRestaurant')->paginate(500);
        }

        return view('admin.reports.clients' , compact('clients' , 'restaurant' , 'city'));
    }
    public function CityRestaurants($id , $status)
    {
        $city = City::find($id);
        if ($status == 'active')
        {
            $restaurants = Restaurant::whereCityId($city->id)
                ->whereStatus('active')
                ->whereType('restaurant')
                ->get();
        }else{
            $restaurants = Restaurant::whereCityId($city->id)
                ->where('status' , '!=' , 'active')
                ->whereType('restaurant')
                ->get();
        }
        return view('admin.reports.restaurants' , compact('city' ,'status', 'restaurants'));
    }

    /**
     * @get @category restaurants
     */
    public function category_reports()
    {
        $categories  = Category::all();
        return view('admin.reports.categories.index' , compact('categories'));
    }
    public function category_restaurants($id)
    {
        $category = Category::find($id);
        $restaurants = $category->restaurant_categories;
        return view('admin.reports.categories.restaurants' , compact('category' , 'restaurants'));
    }
}
