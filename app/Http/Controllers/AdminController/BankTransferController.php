<?php

namespace App\Http\Controllers\AdminController;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\EasyAdsSubscription;
use App\Models\EasyAdsHistory;
use App\Models\AzRestaurantCommission;
use App\Models\AzCommissionHistory;


class BankTransferController extends Controller
{
    public function transfers()
    {
        $transfers = EasyAdsSubscription::whereNotNull('transfer_photo')
            ->wherePayment('false')
            ->get();
        return view('admin.settings.bank_transfers', compact('transfers'));
    }

    public function transfer_status($id, $status)
    {
        $subscription = EasyAdsSubscription::findOrFail($id);
        if ($status == 'confirm'):
            // store operation at history
            EasyAdsHistory::create([
                'restaurant_id' => $subscription->restaurant_id,
                'bank_id' => $subscription->bank_id,
                'seller_code_id' => $subscription->seller_code_id,
                'paid_amount' => $subscription->price,
                'discount' => $subscription->discount_value,
                'tax' => $subscription->tax_value,
                'transfer_photo' => $subscription->transfer_photo,
                'payment_type' => 'bank',
                'admin_id' => auth('admin')->user()->id,
                'subscription_type' => $subscription->status == 'finished' ? 'renew' : 'new',
                'details' => $subscription->status == 'finished' ? trans('messages.renew_subscription') : trans('messages.new_subscription'),
            ]);
            $subscription->update([
                'payment' => 'true',
                'status' => 'active',
                'end_at' => Carbon::now()->addYear(),
                'subscription_type' => $subscription->status == 'finished' ? 'renew' : 'new',
                'transfer_photo' => null,
            ]);
            flash(trans('messages.operationConfirmedSuccessfully'))->success();
        elseif ($status == 'cancel'):
            $subscription->update([
                'transfer_photo' => null,
            ]);
            flash(trans('messages.operationCanceledSuccessfully'))->success();
        endif;
        return redirect()->back();
    }

    public function commission_bank_transfers()
    {
        $transfers = AzRestaurantCommission::whereNotNull('transfer_photo')
            ->whereNull('admin_id')
            ->wherePaymentType('bank')
            ->get();
        return view('admin.settings.commission_bank_transfers', compact('transfers'));
    }
    public function commission_transfer_status($id, $status)
    {
        $commission = AzRestaurantCommission::findOrFail($id);
        $restaurant = $commission->restaurant;
        if ($status == 'confirm'):
            $commission->update([
                'admin_id'     => auth('admin')->user()->id,
                'payment'      => 'true',
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
            $required_commissions = $restaurant->az_orders->where('status' , '!=' , 'new')->sum('commission') - $restaurant->az_commissions()->wherePayment('true')->sum('commission_value');
            if ($required_commissions < $restaurant->maximum_az_commission_limit)
            {
                $restaurant->az_subscription->update([
                    'status' => $restaurant->az_subscription->price == 0 ? 'free' : 'active',
                ]);
            }
            flash(trans('messages.operationConfirmedSuccessfully'))->success();
        elseif ($status == 'cancel'):
            @unlink(public_path('/uploads/commissions_transfers/' . $commission->transfer_photo));
            $commission->delete();
            flash(trans('messages.operationCanceledSuccessfully'))->success();
        endif;
        return redirect()->back();
    }

}
