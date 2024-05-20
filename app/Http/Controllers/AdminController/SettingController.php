<?php

namespace App\Http\Controllers\AdminController;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\EasyAdsSetting;
use App\Models\EasyAdsHistory;
use App\Models\AzSubscription;
use App\Models\Restaurant;
use App\Models\AzCommissionHistory;
use App\Models\AzRestaurantCommission;
use App\Models\Restaurant\Azmak\AZUser;

class SettingController extends Controller
{
    public function setting()
    {
        $settings = EasyAdsSetting::first();
        return view('admin.settings.index' , compact('settings'));
    }
    public function setting_update(Request $request)
    {
        $settings = EasyAdsSetting::first();
        $this->validate($request , [
            'type'  => 'required',
            'subscription_amount'  => 'required',
            'bank_transfer'       => 'nullable',
            'online_payment'      => 'nullable',
            'online_payment_type'  => 'required',
            'myFatoourah_token'  => 'nullable',
            'pay_link_payment_type' => 'nullable|in:test,online',
            'pay_link_app_id'       => 'nullable',
            'pay_link_secret_key'   => 'nullable',
        ]);
        $settings->update([
            'subscription_type'  => $request->type,
            'subscription_amount'  => $request->subscription_amount,
            'tax'        => $request->tax,
            'bank_transfer'      => $request->bank_transfer,
            'online_payment'     => $request->online_payment,
            'online_payment_type' => $request->online_payment_type,
            'myFatoourah_token'  => $request->myFatoourah_token,
            'pay_link_app_id'       => $request->pay_link_app_id,
            'pay_link_secret_key'   => $request->pay_link_secret_key,
        ]);
        flash(trans('messages.updated'))->success();
        return redirect()->back();
    }
    public function histories(Request $request)
    {
        $year = $request->year == null ? Carbon::now()->format('Y') : $request->year;
        $month = $request->month == null ? Carbon::now()->format('m') : $request->month;
        $histories = EasyAdsHistory::orderBy('id' , 'desc')
            ->whereyear('created_at','=',$year)
            ->whereMonth('created_at','=',$month)
            ->paginate(500);
        $month_total_amount = EasyAdsHistory::whereyear('created_at','=',$year)
            ->whereMonth('created_at','=',$month)
            ->sum('paid_amount');
        $tax_values = EasyAdsHistory::whereyear('created_at','=',$year)
            ->whereMonth('created_at','=',$month)
            ->sum('tax');
        $subscribed_restaurants = EasyAdsHistory::where('subscription_type' , 'new')
            ->whereyear('created_at','=',$year)
            ->whereMonth('created_at','=',$month)
            ->count();
        $renewed_restaurants = EasyAdsHistory::where('subscription_type' , 'renew')
            ->whereyear('created_at','=',$year)
            ->whereMonth('created_at','=',$month)
            ->count();
        return view('admin.settings.histories' , compact('histories','renewed_restaurants','subscribed_restaurants','tax_values','month_total_amount' , 'year' , 'month'));
    }
    public function delete_histories($id)
    {
        $EasyAdsHistory = EasyAdsHistory::findOrFail($id);
        $EasyAdsHistory->delete();
        flash(trans('messages.deleted'))->success();
        return redirect()->back();
    }
    public function commission_histories(Request $request)
    {
        $year = $request->year == null ? Carbon::now()->format('Y') : $request->year;
        $month = $request->month == null ? Carbon::now()->format('m') : $request->month;
        if ($request->month == 'all')
        {
            $histories = AzCommissionHistory::orderBy('id' , 'desc')
                ->whereyear('created_at','=',$year)
                ->paginate(500);
            $month_total_amount = AzCommissionHistory::whereyear('created_at','=',$year)
                ->sum('paid_amount');
        }else{
            $histories = AzCommissionHistory::orderBy('id' , 'desc')
                ->whereyear('created_at','=',$year)
                ->whereMonth('created_at','=',$month)
                ->paginate(500);
            $month_total_amount = AzCommissionHistory::whereyear('created_at','=',$year)
                ->whereMonth('created_at','=',$month)
                ->sum('paid_amount');
        }
        return view('admin.settings.commission_histories' , compact('histories','month_total_amount' , 'year' , 'month'));
    }
    public function delete_commission_history($id)
    {
        $EasyAdsHistory = AzCommissionHistory::findOrFail($id);
        // delete commission from restaurant
        $commission = AzRestaurantCommission::whereInvoiceId($EasyAdsHistory->invoice_id)
            ->orWhere('transfer_photo', $EasyAdsHistory->transfer_photo)
            ->first();
        if ($commission)
        {
            $commission->delete();
        }
        $EasyAdsHistory->delete();
        flash(trans('messages.deleted'))->success();
        return redirect()->back();
    }
    public function az_users()
    {
        $users = AZUser::paginate(500);
        return view('admin.users.index' , compact('users'));
    }
    public function restaurant_users($id)
    {
        $restaurant = Restaurant::findOrFail($id);
        $users = $restaurant->users()->paginate(500);
        return view('admin.users.restaurant_users' , compact('users' , 'restaurant'));
    }
}
