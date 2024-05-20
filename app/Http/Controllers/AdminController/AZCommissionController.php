<?php

namespace App\Http\Controllers\AdminController;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Restaurant;
use App\Models\AzCommissionHistory;
use App\Models\AzRestaurantCommission;
use App\Models\Restaurant\Azmak\AZOrder;

class AZCommissionController extends Controller
{
    public function restaurant_commissions($id)
    {
        $restaurant = Restaurant::findOrFail($id);
        $orders_commissions = $restaurant->az_orders->where('status', '!=', 'new')->sum('commission');
        $restaurant_commissions = $restaurant->az_commissions()->wherePayment('true')->sum('commission_value');
        return view('admin.commission.index', compact('restaurant', 'orders_commissions', 'restaurant_commissions'));
    }

    public function restaurant_az_orders($id)
    {
        $restaurant = Restaurant::findOrFail($id);
        $orders = $restaurant->az_orders()->where('status', '!=', 'new')->paginate(500);
        return view('admin.commission.orders', compact('restaurant', 'orders'));
    }

    public function show_order($id)
    {
        $order = AZOrder::findOrFail($id);
        return view('admin.commission.show_order', compact('order'));
    }

    public function commissions_history($id)
    {
        $restaurant = Restaurant::findOrFail($id);
        $histories = $restaurant->az_commissions()->wherePayment('true')->paginate(100);
        return view('admin.commission.commission_history', compact('restaurant', 'histories'));
    }

    public function add_commissions_history($id)
    {
        $restaurant = Restaurant::findOrFail($id);
        return view('admin.commission.create_commission_history', compact('restaurant'));
    }

    public function store_commissions_history(Request $request, $id)
    {
        $restaurant = Restaurant::findOrFail($id);
        $this->validate($request, [
            'commission_value' => 'required|numeric',
            'transfer_photo' => 'required|mimes:jpg,jpeg,png,gif,tif,psd,webp,bmp|max:5000',
        ]);

        // add new commission
        $commission = AzRestaurantCommission::create([
            'restaurant_id' => $restaurant->id,
            'admin_id' => auth('admin')->user()->id,
            'payment' => 'true',
            'commission_value' => $request->commission_value,
            'transfer_photo' => UploadImage($request->file('transfer_photo'), 'photo', '/uploads/commissions_transfers'),
        ]);
        // store operation at history
        AzCommissionHistory::create([
            'restaurant_id' => $commission->restaurant_id,
            'bank_id' => $commission->bank_id,
            'paid_amount' => $commission->commission_value,
            'transfer_photo' => $commission->transfer_photo,
            'payment_type' => 'bank',
            'admin_id' => auth('admin')->user()->id,
        ]);
        $required_commissions = $restaurant->az_orders->where('status', '!=', 'new')->sum('commission') - $restaurant->az_commissions()->wherePayment('true')->sum('commission_value');
        if ($required_commissions < $restaurant->maximum_az_commission_limit) {
            $restaurant->az_subscription->update([
                'status' => 'active',
            ]);
        }
        flash(trans('messages.created'))->success();
        return redirect()->route('AzRestaurantCommissionsHistory', $restaurant->id);
    }

    public function delete_commissions_history($id)
    {
        $history = AzRestaurantCommission::findOrFail($id);
        $restaurant = $history->restaurant;
        // delete commission from history
        AzCommissionHistory::whereInvoiceId($history->invoice_id)
            ->orWhere('transfer_photo', $history->transfer_photo)
            ->delete();
        if ($history->transfer_photo):
            @unlink(public_path('/uploads/commissions_transfers/' . $history->transfer_photo));
        endif;
        $history->delete();
        $required_commissions = $restaurant->az_orders->where('status', '!=', 'new')->sum('commission') - $restaurant->az_commissions()->wherePayment('true')->sum('commission_value');
        if ($required_commissions > $restaurant->maximum_az_commission_limit) {
            $restaurant->az_subscription->update([
                'status' => 'commission_hold',
            ]);
        }
        flash(trans('messages.deleted'))->success();
        return redirect()->back();
    }
}
