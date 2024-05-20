<?php

namespace App\Http\Controllers\AdminController;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Restaurant;
use Illuminate\Support\Facades\Auth;

class AZRestaurantController extends Controller
{
    public function index($status)
    {
        $restaurants = Restaurant::with('az_subscription')
            ->whereHas('az_subscription', function ($q) use ($status) {
                $q->whereStatus($status);
            })->paginate(200);
        return view('admin.restaurants.index', compact('restaurants', 'status'));
    }

    public function loginToRestaurant(Request $request, Restaurant $restaurant)
    {
        Auth::guard('restaurant')->login($restaurant, true);
        return redirect(route('restaurant.home'));
    }

    public function edit($id)
    {
        $restaurant = Restaurant::findOrFail($id);
        return view('admin.restaurants.edit', compact('restaurant'));
    }

    public function update(Request $request, $id)
    {
        $restaurant = Restaurant::findOrFail($id);
        $this->validate($request, [
            'a_z_orders_payment_type'     => 'required|in:myFatoourah,tap,edfa,payLink',
            'a_z_tap_token'               => 'required_if:a_z_orders_payment_type,tap',
            'a_z_myFatoourah_token'       => 'required_if:a_z_orders_payment_type,myFatoourah',
            'a_z_edfa_merchant'           => 'required_if:a_z_orders_payment_type,edfa',
            'a_z_edfa_password'           => 'required_if:a_z_orders_payment_type,edfa',
            'az_commission'               => 'required',
            'maximum_az_commission_limit' => 'required',
            'pay_link_app_id'             => 'required_if:a_z_orders_payment_type,payLink',
            'pay_link_secret_key'         => 'required_if:a_z_orders_payment_type,payLink',

//            'az_online_payment_type'    => 'required|in:test,online'
        ]);
        $restaurant->update([
            'a_z_orders_payment_type'     => $request->a_z_orders_payment_type,
            'a_z_tap_token'               => $request->a_z_tap_token == null ? $restaurant->a_z_tap_token : $request->a_z_tap_token,
            'a_z_myFatoourah_token'       => $request->a_z_myFatoourah_token == null ? $restaurant->a_z_myFatoourah_token : $request->a_z_myFatoourah_token,
            'a_z_edfa_merchant'           => $request->a_z_edfa_merchant == null ? $restaurant->a_z_edfa_merchant : $request->a_z_edfa_merchant,
            'a_z_edfa_password'           => $request->a_z_edfa_password == null ? $restaurant->a_z_edfa_password : $request->a_z_edfa_password,
            'az_commission'               => $request->az_commission,
            'maximum_az_commission_limit' => $request->maximum_az_commission_limit,
            'pay_link_app_id'             => $request->pay_link_app_id,
            'pay_link_secret_key'         => $request->pay_link_secret_key,
//            'az_online_payment_type'    => $request->az_online_payment_type,
        ]);
        flash(trans('messages.updated'))->success();
        return redirect()->route('restaurants', $restaurant->az_subscription->status);
    }

}
