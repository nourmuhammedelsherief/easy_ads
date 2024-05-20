<?php

namespace App\Http\Controllers\AdminController;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\Restaurant;
use App\Models\AzSubscription;
use App\Models\AzHistory;
use App\Models\AzRestaurantCommission;
use App\Models\Restaurant\Azmak\AZOrder;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $year = $request->year == null ? Carbon::now()->format('Y') : $request->year;
        $month = $request->month == null ? Carbon::now()->format('m') : $request->month;
        $restaurants = Restaurant::with('az_subscription')
            ->whereHas('az_subscription', function ($q) {
                $q->whereStatus('new');
            })->count();
        $new_not_paid = AzSubscription::whereStatus('new')
            ->whereyear('created_at', '=', $year)
            ->whereMonth('created_at', '=', $month)
            ->count();
        $subscribed_restaurants = AzHistory::whereSubscriptionType('new')
            ->whereyear('created_at', '=', $year)
            ->whereMonth('created_at', '=', $month)
            ->count();
        $subscribed_restaurants_amount = AzHistory::whereSubscriptionType('new')
            ->whereyear('created_at', '=', $year)
            ->whereMonth('created_at', '=', $month)
            ->sum('paid_amount');
        $renewed_restaurants = AzHistory::whereSubscriptionType('renew')
            ->whereyear('created_at', '=', $year)
            ->whereMonth('created_at', '=', $month)
            ->count();
        $renewed_restaurants_amount = AzHistory::whereSubscriptionType('renew')
            ->whereyear('created_at', '=', $year)
            ->whereMonth('created_at', '=', $month)
            ->sum('paid_amount');
        $free = AzSubscription::whereStatus('free')
            ->whereyear('created_at', '=', $year)
            ->whereMonth('created_at', '=', $month)
            ->count();
        $orders_commissions = AZOrder::where('status', '!=', 'new')
            ->whereyear('created_at', '=', $year)
            ->whereMonth('created_at', '=', $month)
            ->sum('commission');
        $restaurant_commissions = AzRestaurantCommission::wherePayment('true')
            ->whereyear('created_at', '=', $year)
            ->whereMonth('created_at', '=', $month)
            ->sum('commission_value');

        return view('admin.reports.index', compact('new_not_paid', 'orders_commissions', 'restaurant_commissions', 'renewed_restaurants_amount', 'subscribed_restaurants_amount', 'subscribed_restaurants', 'renewed_restaurants', 'free', 'month', 'year'));
    }

    public function restaurants($year, $month, $type)
    {
        if ($type == 'new') {
            $restaurants = AzSubscription::whereStatus('new')
                ->whereyear('created_at', '=', $year)
                ->whereMonth('created_at', '=', $month)
                ->paginate(200);
            $status = 'new';
        } elseif ($type == 'active') {
            $restaurants = AzHistory::whereSubscriptionType('new')
                ->whereyear('created_at', '=', $year)
                ->whereMonth('created_at', '=', $month)
                ->paginate(200);
            $status = 'active';
        } elseif ($type == 'free') {
            $restaurants = AzSubscription::whereStatus('free')
                ->whereyear('created_at', '=', $year)
                ->whereMonth('created_at', '=', $month)
                ->paginate(200);
            $status = 'free';
        } elseif ($type == 'renew') {
            $restaurants = AzHistory::whereSubscriptionType('renew')
                ->whereyear('created_at', '=', $year)
                ->whereMonth('created_at', '=', $month)
                ->paginate(200);
            $status = 'renew';
        }
        return view('admin.reports.restaurants', compact('restaurants', 'status', 'month', 'year'));
    }

    public function report_histories(Request $request)
    {
        $year = $request->year == null ? Carbon::now()->format('Y') : $request->year;
        $month = $request->month == null ? Carbon::now()->format('m') : $request->month;
        $histories = AzHistory::orderBy('id', 'desc')
            ->whereyear('created_at', '=', $year)
            ->whereMonth('created_at', '=', $month)
            ->paginate(500);
        $month_total_amount = AzHistory::whereyear('created_at', '=', $year)
            ->whereMonth('created_at', '=', $month)
            ->sum('paid_amount');
        $tax_values = AzHistory::whereyear('created_at', '=', $year)
            ->whereMonth('created_at', '=', $month)
            ->sum('tax');
        $subscribed_restaurants = AzHistory::where('subscription_type', 'new')
            ->whereyear('created_at', '=', $year)
            ->whereMonth('created_at', '=', $month)
            ->count();
        $renewed_restaurants = AzHistory::where('subscription_type', 'renew')
            ->whereyear('created_at', '=', $year)
            ->whereMonth('created_at', '=', $month)
            ->count();
        return view('admin.settings.histories', compact('histories', 'renewed_restaurants', 'subscribed_restaurants', 'tax_values', 'month_total_amount', 'year', 'month'));
    }

    public function payable_commissions_restaurants($year, $month)
    {
        $restaurants = AzSubscription::where('status', '!=', 'new')->paginate(200);
        return view('admin.reports.payable_commissions_restaurants', compact('restaurants', 'month', 'year'));
    }

    public function report_orders($year, $month)
    {
        $orders = AZOrder::where('status', '!=', 'new')
            ->whereyear('created_at', '=', $year)
            ->whereMonth('created_at', '=', $month)
            ->paginate(500);
        return view('admin.reports.orders', compact('orders' , 'year' , 'month'));
    }
    public function report_commissions($year , $month)
    {
        $histories = AzRestaurantCommission::wherePayment('true')
            ->whereyear('created_at', '=', $year)
            ->whereMonth('created_at', '=', $month)
            ->paginate(100);
        return view('admin.reports.commission_history', compact( 'histories' , 'year' , 'month'));
    }
}
