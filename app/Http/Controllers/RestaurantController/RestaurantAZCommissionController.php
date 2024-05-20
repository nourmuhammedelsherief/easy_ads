<?php

namespace App\Http\Controllers\RestaurantController;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;

use App\Models\Restaurant;
use App\Models\Bank;
use App\Models\AzCommissionHistory;
use App\Models\AzmakSetting;
use App\Models\AzRestaurantCommission;
use App\Models\Restaurant\Azmak\AZOrder;

class RestaurantAZCommissionController extends Controller
{
    public function commissions_history($id)
    {
        $restaurant = Restaurant::findOrFail($id);
        $histories = $restaurant->az_commissions()->paginate(100);
        return view('restaurant.commission.commission_history' , compact('restaurant' , 'histories'));
    }
    public function add_commissions_history($id){
        $restaurant = Restaurant::findOrFail($id);
        $banks = Bank::whereNull('restaurant_id')->where('country_id', $restaurant->country_id)->get();
        $setting = AzmakSetting::first();
        return view('restaurant.commission.create_commission_history' , compact('restaurant' , 'banks' , 'setting'));
    }

    public function store_commissions_history(Request $request , $id)
    {
        $restaurant = Restaurant::findOrFail($id);
        $this->validate($request , [
            'commission_value' => 'required|numeric',
            'payment_method'   => 'required|in:bank,online',
            'bank_id'          => 'required_if:payment_method,bank',
            'transfer_photo'   => 'required_if:payment_method,bank|mimes:jpg,jpeg,png,gif,tif,psd,webp,bmp|max:5000',
//            'payment_type'     => 'required_if:payment_method,online'
        ]);

        $setting = AzmakSetting::first();

        if ($request->commission_value < 5)
        {
            flash(trans('messages.limitCommission'))->error();
            return  redirect()->back();
        }

        if ($request->payment_method == 'bank')
        {
            // add new commission
            AzRestaurantCommission::create([
                'restaurant_id'     => $restaurant->id,
                'payment_type'      => 'bank',
                'payment'           => 'false',
                'bank_id'           => $request->bank_id,
                'commission_value'  => $request->commission_value,
                'transfer_photo'    => UploadImage($request->file('transfer_photo'), 'photo', '/uploads/commissions_transfers'),
            ]);
        }elseif ($request->payment_method == 'online' and $setting->online_payment == 'myFatoourah')
        {
            $setting = AzmakSetting::first();
            $name = $restaurant->name_en;
            $token = $setting->online_token;
            $data = array(
                'PaymentMethodId' => $request->payment_type,
                'CustomerName' => $name,
                'DisplayCurrencyIso' => 'SAR',
                'MobileCountryCode' => $restaurant->country->code,
                'CustomerMobile' => $restaurant->phone_number,
                'CustomerEmail' => $restaurant->email,
                'InvoiceValue' => $request->commission_value,
                'CallBackUrl' => route('AZOnlineCommissionStatus'),
                'ErrorUrl' => route('restaurant.home'),
                'Language' => app()->getLocale(),
                'CustomerReference' => 'ref 1',
                'CustomerCivilId' => '12345678',
                'UserDefinedField' => 'Custom field',
                'ExpireDate' => '',
                'CustomerAddress' => array(
                    'Block' => '',
                    'Street' => '',
                    'HouseBuildingNo' => '',
                    'Address' => '',
                    'AddressInstructions' => '',
                ),
                'InvoiceItems' => [array(
                    'ItemName' => $restaurant->name_en,
                    'Quantity' => 1,
                    'UnitPrice' => $request->commission_value,
                )],
            );
            $data = json_encode($data);
            $fatooraRes = MyFatoorah($token, $data);
            $result = json_decode($fatooraRes);
            if ($result != null and $result->IsSuccess === true) {
                AzRestaurantCommission::create([
                    'restaurant_id'      => $restaurant->id,
                    'payment_type'       => 'online',
                    'commission_value'   => $request->commission_value,
                    'invoice_id'         => $result->Data->InvoiceId,
                    'payment'            => 'false',
                ]);
                return redirect()->to($result->Data->PaymentURL);
            } else {
                flash(trans('messages.paymentError'))->error();
                return back();
            }
        }  elseif ($request->payment_method == 'online' and $setting->online_payment == 'paylink')
        {
            $commission = AzRestaurantCommission::create([
                'restaurant_id'      => $restaurant->id,
                'payment_type'       => 'online',
                'commission_value'   => $request->commission_value,
                'invoice_id'         => $restaurant->id,
                'payment'            => 'false',
            ]);
            return redirect()->to(payLinkAddInvoice($request->commission_value , $restaurant->email,$restaurant->phone_number,$restaurant->name_en,$restaurant->az_subscription->id , route('AZPayLinkCommissionStatus' , $commission->id)));
        }
        flash(trans('messages.CommissionAddedSuccessfully'))->success();
        return redirect()->route('RestaurantAzCommissionsHistory' , $restaurant->id);
    }
    public function online_commission_status(Request $request)
    {
        $setting = AzmakSetting::first();
        $token = $setting->online_token;
        $PaymentId = $request->query('paymentId');
        $resData = MyFatoorahStatus($token, $PaymentId);
        $result = json_decode($resData);
        if ($result->IsSuccess === true and $result->Data->InvoiceStatus === "Paid") {
            $InvoiceId = $result->Data->InvoiceId;
            $commission = AzRestaurantCommission::whereInvoiceId($InvoiceId)->first();
            $restaurant = $commission->restaurant;
            // store operation at history
            // store operation at history
            AzCommissionHistory::create([
                'restaurant_id' => $commission->restaurant_id,
                'paid_amount' => $commission->commission_value,
                'payment_type' => 'online',
                'invoice_id' => $InvoiceId,
            ]);
            $commission->update([
                'payment' => 'true',
            ]);
            $required_commissions = $restaurant->az_orders->where('status' , '!=' , 'new')->sum('commission') - $restaurant->az_commissions()->wherePayment('true')->sum('commission_value');
            if ($required_commissions < $restaurant->maximum_az_commission_limit)
            {
                $restaurant->az_subscription->update([
                    'status' => 'active',
                ]);
            }
            flash(trans('messages.paymentDoneSuccessfully'))->success();
            return redirect()->route('restaurant.home');
        } else {
            flash(trans('messages.paymentError'))->error();
            return back();
        }
    }
    public function payLink_commission_status(Request $request , $id)
    {
        $commission = AzRestaurantCommission::find($id);
        if ($commission) {
            $restaurant = $commission->restaurant;
            // store operation at history
            // store operation at history
            AzCommissionHistory::create([
                'restaurant_id' => $commission->restaurant_id,
                'paid_amount' => $commission->commission_value,
                'payment_type' => 'online',
                'invoice_id' => $request->transactionNo,
            ]);
            $commission->update([
                'payment' => 'true',
            ]);
            $required_commissions = $restaurant->az_orders->where('status' , '!=' , 'new')->sum('commission') - $restaurant->az_commissions()->wherePayment('true')->sum('commission_value');
            if ($required_commissions < $restaurant->maximum_az_commission_limit)
            {
                $restaurant->az_subscription->update([
                    'status' => 'active',
                ]);
            }
            flash(trans('messages.paymentDoneSuccessfully'))->success();
            return redirect()->route('restaurant.home');
        } else {
            flash(trans('messages.paymentError'))->error();
            return back();
        }
    }
    public function delete_commissions_history($id)
    {
        $history = AzRestaurantCommission::findOrFail($id);
        $restaurant = $history->restaurant;
        @unlink(public_path('/uploads/commissions_transfers/' . $history->transfer_photo));
        $history->delete();
        $required_commissions = $restaurant->az_orders->where('status' , '!=' , 'new')->sum('commission') - $restaurant->az_commissions()->wherePayment('true')->sum('commission_value');
        if ($required_commissions > $restaurant->maximum_az_commission_limit)
        {
            $restaurant->az_subscription->update([
                'status' => 'commission_hold',
            ]);
        }
        flash(trans('messages.deleted'))->success();
        return redirect()->back();
    }
}
