<?php

namespace App\Http\Controllers\RestaurantController;

use App\Http\Controllers\Controller;
use App\Models\Bank;
use App\Models\EasyAdsSellerCode;
use App\Models\EasyAdsSetting;
use App\Models\EasyAdsSubscription;
use App\Models\EasyAdsHistory;
use App\Models\Restaurant;
use App\Models\RestaurantTermsCondition;
use Carbon\Carbon;
use Illuminate\Http\Request;

class EasyAdsSubscriptionController extends Controller
{
    public function show_subscription($id)
    {
        $restaurant = Restaurant::find($id);
        // get azmak setting subscription type
        $settings = EasyAdsSetting::first();
        if ($settings->subscription_type == 'free') {
            // 1 - free subscription
            EasyAdsSubscription::updateOrCreate(
                ['restaurant_id' => $restaurant->id],
                [
                    'status' => 'free',
                    'end_at' => Carbon::now()->addYears(1),
                    'subscription_type' => 'new',
                ]);
//            $this->create_default_data($restaurant->id);
            flash(trans('messages.EasyAdsFreeSubscriptionDoneSuccessfully'))->success();
            return redirect()->back();
        } elseif ($settings->subscription_type == 'paid') {
            // 2 - paid Payment
            $setting = EasyAdsSetting::first();
            return view('restaurant.payments.payment_method', compact('restaurant' , 'setting'));
        }
    }

    public function show_payment_methods(Request $request, $id)
    {
        $this->validate($request, [
            'payment_method' => 'required|in:bank,online',
//            'payment_type' => 'required_if:payment_method,online|in:2,6,11,14',
            'seller_code' => 'nullable|exists:easy_ads_seller_codes,seller_name',
        ]);
        $restaurant = Restaurant::findOrFail($id);
        $setting = EasyAdsSetting::first();
        $name = $restaurant->name_en;
        $token = $setting->myFatoourah_token;
        $amount = $setting->subscription_amount;
        $seller_code = null;
        $tax = $setting->tax;
        $discount = 0;
        if ($request->seller_code != null) {
            $seller_code = EasyAdsSellerCode::where('seller_name', $request->seller_code)
                ->whereActive('true')
                ->where('country_id', $restaurant->country_id)
                ->first();
            if ($seller_code) {
                if ($seller_code->start_at <= Carbon::now() and $seller_code->end_at >= Carbon::now()) {
                    $discount_percentage = $seller_code->code_percentage;
                    $discount = ($amount * $discount_percentage) / 100;
                    $price_after_percentage = $amount - $discount;
                    $commission = $amount * ($seller_code->percentage - $seller_code->code_percentage) / 100;
                    $seller_code->update([
                        'commission' => $commission + $seller_code->commission,
                    ]);
                    $tax_value = $price_after_percentage * $tax / 100;
                    $amount = $price_after_percentage + $tax_value;
                } else {
                    $tax_value = $amount * $tax / 100;
                    $amount += $tax_value;
                }
            } else {
                $tax_value = $amount * $tax / 100;
                $amount += $tax_value;
            }
        } else {
            $tax_value = $amount * $tax / 100;
            $amount += $tax_value;
        }

        if ($request->payment_method == 'bank') {
            if ($restaurant->ads_subscription) {
                $restaurant->ads_subscription->update([
                    'payment_type' => 'bank',
                    'payment' => 'false',
                    'price' => $amount,
                    'seller_code_id' => $seller_code?->id,
                    'tax_value' => $tax_value,
                    'discount_value' => $discount,
                ]);
            } else {
                EasyAdsSubscription::create([
                    'restaurant_id' => $restaurant->id,
                    'payment_type' => 'bank',
                    'payment' => 'false',
                    'status' => 'new',
                    'subscription_type' => 'new',
                    'price' => $amount,
                    'seller_code_id' => $seller_code?->id,
                    'tax_value' => $tax_value,
                    'discount_value' => $discount,
                ]);
            }
//            AZRestaurantInfo::updateOrCreate(
//                ['restaurant_id' => $restaurant->id],
//            );
            $banks = Bank::whereNull('restaurant_id')->where('country_id', $restaurant->country_id)->get();
            return view('restaurant.payments.bank_transfer', compact('restaurant', 'banks', 'amount', 'discount', 'tax', 'tax_value'));
        }
        elseif ($request->payment_method == 'online' and $setting->online_payment == 'myFatoourah') {
            $data = array(
                'PaymentMethodId' => $request->payment_type,
                'CustomerName' => $name,
                'DisplayCurrencyIso' => 'SAR',
                'MobileCountryCode' => $restaurant->country->code,
                'CustomerMobile' => $restaurant->phone_number,
                'CustomerEmail' => $restaurant->email,
                'InvoiceValue' => $amount,
                'CallBackUrl' => route('EasyAdsSubscriptionStatusF'),
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
                    'UnitPrice' => $amount,
                )],
            );
            $data = json_encode($data);
            $fatooraRes = MyFatoorah($token, $data);
            $result = json_decode($fatooraRes);
            if ($result != null and $result->IsSuccess === true) {
                if ($restaurant->ads_subscription) {
                    $restaurant->ads_subscription->update([
                        'invoice_id' => $result->Data->InvoiceId,
                        'payment_type' => 'online',
                        'payment' => 'false',
                        'price' => $amount,
                        'seller_code_id' => $seller_code?->id,
                        'tax_value' => $tax_value,
                        'discount_value' => $discount,
                    ]);
                } else {
                    EasyAdsSubscription::create([
                        'restaurant_id' => $restaurant->id,
                        'payment_type' => 'online',
                        'payment' => 'false',
                        'status' => 'new',
                        'subscription_type' => 'new',
                        'price' => $amount,
                        'seller_code_id' => $seller_code?->id,
                        'tax_value' => $tax_value,
                        'discount_value' => $discount,
                        'invoice_id' => $result->Data->InvoiceId,
                    ]);
                }
//                AZRestaurantInfo::updateOrCreate(
//                    ['restaurant_id' => $restaurant->id],
//                );
                return redirect()->to($result->Data->PaymentURL);
            } else {
                flash(trans('messages.paymentError'))->error();
                return back();
            }
        }
        elseif ($request->payment_method == 'online' and $setting->online_payment == 'paylink')
        {
            if ($restaurant->ads_subscription) {
                $restaurant->ads_subscription->update([
                    'payment_type' => 'online',
                    'payment' => 'false',
                    'price' => $amount,
                    'seller_code_id' => $seller_code?->id,
                    'tax_value' => $tax_value,
                    'discount_value' => $discount,
                ]);
                $subscription = $restaurant->ads_subscription;
            } else {
                $subscription = EasyAdsSubscription::create([
                    'restaurant_id' => $restaurant->id,
                    'payment_type' => 'online',
                    'payment' => 'false',
                    'status' => 'new',
                    'subscription_type' => 'new',
                    'price' => $amount,
                    'seller_code_id' => $seller_code?->id,
                    'tax_value' => $tax_value,
                    'discount_value' => $discount,
                ]);
            }
//            AZRestaurantInfo::updateOrCreate(
//                ['restaurant_id' => $restaurant->id],
//            );
            if ($subscription)
            {
                return redirect()->to(payLinkAddInvoice($amount , $restaurant->email,$restaurant->phone_number,$restaurant->name_en,$subscription->id , route('EasyAdsSubscriptionPayLinkStatus' , $restaurant->id)));
            }
        }
    }

    public function bank_transfer(Request $request, $id)
    {
        $this->validate($request, [
            'bank_id' => 'required',
            'transfer_photo' => 'required|mimes:jpg,jpeg,png,gif,tif,psd,pmp,webp|max:5000'
        ]);
        $restaurant = Restaurant::findOrFail($id);
        $restaurant->ads_subscription->update([
            'bank_id' => $request->bank_id,
            'transfer_photo' => UploadImage($request->file('transfer_photo'), 'transfer_photo', '/uploads/az_transfers'),
        ]);
//        $this->create_default_data($restaurant->id);
        flash(trans('messages.waitAdminAccept'))->success();
        return redirect()->to('/console/home');
    }

    public function subscription_status(Request $request)
    {
        $setting = EasyAdsSetting::first();
        $token = $setting->myFatoourah_token;
        $PaymentId = $request->query('paymentId');
        $resData = MyFatoorahStatus($token, $PaymentId);
        $result = json_decode($resData);
        if ($result->IsSuccess === true and $result->Data->InvoiceStatus === "Paid") {
            $InvoiceId = $result->Data->InvoiceId;
            $subscription = EasyAdsSubscription::whereInvoiceId($InvoiceId)->first();
            // store operation at history
            EasyAdsHistory::create([
                'restaurant_id' => $subscription->restaurant_id,
                'seller_code_id' => $subscription->seller_code_id,
                'paid_amount' => $subscription->price,
                'discount' => $subscription->discount_value,
                'tax' => $subscription->tax_value,
                'invoice_id' => $subscription->invoice_id,
                'payment_type' => 'online',
                'subscription_type' => $subscription->status == 'finished' ? 'renew' : 'new',
                'details' => $subscription->status == 'finished' ? trans('messages.renew_subscription') : trans('messages.new_subscription'),
            ]);
            $subscription->update([
                'status' => 'active',
                'payment' => 'true',
                'end_at' => Carbon::now()->addYear(),
                'subscription_type' => $subscription->status == 'finished' ? 'renew' : 'new',
                'invoice_id' => null,
            ]);
//            $this->create_default_data($subscription->restaurant_id);
            flash(trans('messages.paymentDoneSuccessfully'))->success();
            return redirect()->route('restaurant.home');
        } else {
            flash(trans('messages.paymentError'))->error();
            return back();
        }
    }

    public function payLink_status($id)
    {
        $restaurant  = Restaurant::find($id);
        $subscription = $restaurant->ads_subscription;
        // store operation at history
        EasyAdsHistory::create([
            'restaurant_id' => $subscription->restaurant_id,
            'seller_code_id' => $subscription->seller_code_id,
            'paid_amount' => $subscription->price,
            'discount' => $subscription->discount_value,
            'tax' => $subscription->tax_value,
            'invoice_id' => $subscription->invoice_id,
            'payment_type' => 'online',
            'subscription_type' => $subscription->status == 'finished' ? 'renew' : 'new',
            'details' => $subscription->status == 'finished' ? trans('messages.renew_subscription') : trans('messages.new_subscription'),
        ]);
        $subscription->update([
            'status' => 'active',
            'payment' => 'true',
            'end_at' => Carbon::now()->addYear(),
            'subscription_type' => $subscription->status == 'finished' ? 'renew' : 'new',
        ]);
//        $this->create_default_data($subscription->restaurant_id);
        flash(trans('messages.paymentDoneSuccessfully'))->success();
        return redirect()->route('restaurant.home');
    }

    public function create_default_data($restaurant_id)
    {
        // check sliders
        $sliders = AzRestaurantSlider::whereRestaurantId($restaurant_id)->get();
        if ($sliders->count() == 0) {
            // 1- create restaurant slider
            AzRestaurantSlider::create([
                'restaurant_id' => $restaurant_id,
                'photo' => 'default1.png',
                'type' => 'image',
                'stop' => 'false',
            ]);
            AzRestaurantSlider::create([
                'restaurant_id' => $restaurant_id,
                'photo' => 'default2.png',
                'type' => 'image',
                'stop' => 'false',
            ]);
        }
        if (RestaurantTermsCondition::whereRestaurantId($restaurant_id)->first() == null) {
            // create default terms and condition
            RestaurantTermsCondition::create([
                'restaurant_id' => $restaurant_id,
                'terms_ar' => 'الشروط والأحكام نص يتم أدخاله وتعديله من لوحه تحكم المطعم',
                'terms_en' => 'Text Entered And Edited From Restaurant Control Panel',
            ]);
        }
        if (RestaurantAboutAzmak::whereRestaurantId($restaurant_id)->first() == null) {
            // create restaurant About
            RestaurantAboutAzmak::create([
                'restaurant_id' => $restaurant_id,
                'about_ar' => 'من نحن نص يتم إدخاله وتعديله من لوحه تحكم أداره المطعم',
                'about_en' => 'About Us Text Entered And Edited From Restaurant Control Panel',
            ]);
        }
        $restaurant = Restaurant::find($restaurant_id);
        if ($restaurant->az_logo == null) {
            $restaurant->update([
                'az_logo' => 'default_logo.jpg',
            ]);
        } elseif ($restaurant->a_z_myFatoourah_token == null) {
            $restaurant->update([
                'a_z_myFatoourah_token' => 'rLtt6JWvbUHDDhsZnfpAhpYk4dxYDQkbcPTyGaKp2TYqQgG7FGZ5Th_WD53Oq8Ebz6A53njUoo1w3pjU1D4vs_ZMqFiz_j0urb_BH9Oq9VZoKFoJEDAbRZepGcQanImyYrry7Kt6MnMdgfG5jn4HngWoRdKduNNyP4kzcp3mRv7x00ahkm9LAK7ZRieg7k1PDAnBIOG3EyVSJ5kK4WLMvYr7sCwHbHcu4A5WwelxYK0GMJy37bNAarSJDFQsJ2ZvJjvMDmfWwDVFEVe_5tOomfVNt6bOg9mexbGjMrnHBnKnZR1vQbBtQieDlQepzTZMuQrSuKn-t5XZM7V6fCW7oP-uXGX-sMOajeX65JOf6XVpk29DP6ro8WTAflCDANC193yof8-f5_EYY-3hXhJj7RBXmizDpneEQDSaSz5sFk0sV5qPcARJ9zGG73vuGFyenjPPmtDtXtpx35A-BVcOSBYVIWe9kndG3nclfefjKEuZ3m4jL9Gg1h2JBvmXSMYiZtp9MR5I6pvbvylU_PP5xJFSjVTIz7IQSjcVGO41npnwIxRXNRxFOdIUHn0tjQ-7LwvEcTXyPsHXcMD8WtgBh-wxR8aKX7WPSsT1O8d8reb2aR7K3rkV3K82K_0OgawImEpwSvp9MNKynEAJQS6ZHe_J_l77652xwPNxMRTMASk1ZsJL',
            ]);
        }
        if ($restaurant->az_info and $restaurant->az_info->description_ar == null and $restaurant->az_info->description_en == null) {
            $restaurant->az_info->update([
                'description_ar' => 'وصف المطعم يتم أدخاله وتعديل من لوحه تحكم المطعم',
                'description_en' => 'Restaurant Description Entered And Edited From RestaurantControl Panel',
            ]);
        } elseif ($restaurant->az_info == null) {
            AZRestaurantInfo::create([
                'restaurant_id' => $restaurant->id,
                'description_ar' => 'وصف المطعم يتم أدخاله وتعديل من لوحه تحكم المطعم',
                'description_en' => 'Restaurant Description Entered And Edited From RestaurantControl Panel',
            ]);
        }
        // sensitivities
        if ($restaurant->sensitivities->count() == 0) {
            // create new sensitivities
            AZRestaurantSensitivity::create([
                'restaurant_id' => $restaurant->id,
                'name_ar' => 'الأسماك ومنتجاتها',
                'name_en' => 'Fish and its products',
                'photo' => 'fish.png',
                'details_ar' => 'مثل لحوم الأسماك وزيت السمك',
                'details_en' => 'Like fish and fish oil',
            ]);
            AZRestaurantSensitivity::create([
                'restaurant_id' => $restaurant->id,
                'name_ar' => 'البيض ومنتجاته',
                'name_en' => 'eggs and its products',
                'photo' => 'egg.png',
                'details_ar' => 'مثل المايونيز',
                'details_en' => 'Like mayonnaise',
            ]);
            AZRestaurantSensitivity::create([
                'restaurant_id' => $restaurant->id,
                'name_ar' => 'الحبوب التي تحتوي على مادة الجلوتين',
                'name_en' => 'Cereals that contain gluten',
                'photo' => 'seeds.png',
                'details_ar' => 'مثل (القمح والشعير والشوفان والشيلم ســـواء الأنواع الأصلية منها أو المهجنة أو منتجاتها).',
                'details_en' => 'Such as (wheat, barley, oats and rye, whether original or hybrid types or their products).',
            ]);
            AZRestaurantSensitivity::create([
                'restaurant_id' => $restaurant->id,
                'name_ar' => 'القشـــريات ومنتجاتها',
                'name_en' => 'Crustaceans and their products',
                'photo' => 'jamp.png',
                'details_ar' => 'مثل (ربيان، ســـرطان البحر أو ما يعرف بالسلطعون، جراد البحر أو ما يعرف باللوبستر).',
                'details_en' => 'Such as (prawns, crabs or what is known as crab, lobster or what is known as lobster).',
            ]);
            AZRestaurantSensitivity::create([
                'restaurant_id' => $restaurant->id,
                'name_ar' => 'الحليب ومنتجاته (التـــي تحتوي على ال?كتوز)',
                'name_en' => 'Milk and milk products (containing lactose)',
                'photo' => 'milk.png',
                'details_ar' => 'مثل الحليب والحليب المنكه',
                'details_en' => 'Like milk and flavored milk',
            ]);
            AZRestaurantSensitivity::create([
                'restaurant_id' => $restaurant->id,
                'name_ar' => 'الخردل ومنتجاته',
                'name_en' => 'Mustard and its products',
                'photo' => 'ghrdl.png',
                'details_ar' => 'مثل بـــذور الخردل، زيـــتالخردل، صلصة الخردل',
                'details_en' => 'Like mustard seeds, mustard oil, mustard sauce',
            ]);
            AZRestaurantSensitivity::create([
                'restaurant_id' => $restaurant->id,
                'name_ar' => 'الرخويات ومنتجاتها',
                'name_en' => 'Mollusks and their products',
                'photo' => 'rghoyat.png',
                'details_ar' => 'مثل (الحبار، الحلـــزون البحري، بلح البحر، واأسكالوب)',
                'details_en' => 'Such as (squid, sea snail, mussels, and scallops)',
            ]);
            AZRestaurantSensitivity::create([
                'restaurant_id' => $restaurant->id,
                'name_ar' => 'الفول السوداني ومنتجاته',
                'name_en' => 'Peanut and its products',
                'photo' => 'foul.png',
                'details_ar' => 'مثل زبدة الـفول السوداني',
                'details_en' => 'Like peanut butter',
            ]);
            AZRestaurantSensitivity::create([
                'restaurant_id' => $restaurant->id,
                'name_ar' => 'الكبريتيت',
                'name_en' => 'sulfites',
                'photo' => 'kbret.png',
                'details_ar' => 'بتركيز 10 جزء في المليون أو أكثر',
                'details_en' => 'At a concentration of 10 ppm or more',
            ]);
            AZRestaurantSensitivity::create([
                'restaurant_id' => $restaurant->id,
                'name_ar' => 'الكرفس ومنتجاته',
                'name_en' => 'Celery and its products',
                'photo' => 'krfs.png',
                'details_ar' => 'مثل بذور الكرفس وملح الكرفس',
                'details_en' => 'Like celery seeds and celery salt',
            ]);
            AZRestaurantSensitivity::create([
                'restaurant_id' => $restaurant->id,
                'name_ar' => 'المكسرات ومنتجاتها',
                'name_en' => 'Nuts and their products',
                'photo' => 'mksrat.png',
                'details_ar' => 'مثـــل الكاجو والفســـتق وغيرها',
                'details_en' => 'Like cashews, pistachios, etc',
            ]);
            AZRestaurantSensitivity::create([
                'restaurant_id' => $restaurant->id,
                'name_ar' => 'فول الصويا ومنتجاته',
                'name_en' => 'Soybean and its products',
                'photo' => 'soya.png',
                'details_ar' => 'مثل حليب الصويا',
                'details_en' => 'like soy milk',
            ]);
            AZRestaurantSensitivity::create([
                'restaurant_id' => $restaurant->id,
                'name_ar' => 'لوبين (الترمس ومنتجاتها)',
                'name_en' => 'Lupine (lupine and its products)',
                'photo' => 'trms.png',
                'details_ar' => 'مثل زيت الترمس',
                'details_en' => 'like lupine oil',
            ]);
        }
        if ($restaurant->posters->count() == 0) {
            // create restaurant posters
            AZRestaurantPoster::create([
                'restaurant_id' => $restaurant->id,
                'name_ar' => 'الأفضل مبيعاً',
                'name_en' => 'best selling',
                'poster' => 'best.png',
            ]);
            AZRestaurantPoster::create([
                'restaurant_id' => $restaurant->id,
                'name_ar' => 'عرض جديد',
                'name_en' => 'new offer',
                'poster' => 'new.png',
            ]);
            AZRestaurantPoster::create([
                'restaurant_id' => $restaurant->id,
                'name_ar' => 'الافضل مبيعاً (نجمه)',
                'name_en' => 'Best selling',
                'poster' => 'Best_selling.png',
            ]);
            AZRestaurantPoster::create([
                'restaurant_id' => $restaurant->id,
                'name_ar' => 'جديد',
                'name_en' => 'New',
                'poster' => 'New1.png',
            ]);
            AZRestaurantPoster::create([
                'restaurant_id' => $restaurant->id,
                'name_ar' => 'شيف',
                'name_en' => 'Chef',
                'poster' => 'Chef.png',
            ]);
            AZRestaurantPoster::create([
                'restaurant_id' => $restaurant->id,
                'name_ar' => 'عرض',
                'name_en' => 'Offer',
                'poster' => 'Offer.png',
            ]);
            AZRestaurantPoster::create([
                'restaurant_id' => $restaurant->id,
                'name_ar' => 'قريبا',
                'name_en' => 'Coming soon',
                'poster' => 'Coming_soon.png',
            ]);
            AZRestaurantPoster::create([
                'restaurant_id' => $restaurant->id,
                'name_ar' => 'قريبا (ساعه رمليه)',
                'name_en' => 'Coming soon',
                'poster' => 'Coming_soon1.png',
            ]);
            AZRestaurantPoster::create([
                'restaurant_id' => $restaurant->id,
                'name_ar' => 'ثلج',
                'name_en' => 'Ice',
                'poster' => 'Ice.png',
            ]);
            AZRestaurantPoster::create([
                'restaurant_id' => $restaurant->id,
                'name_ar' => 'شتاء',
                'name_en' => 'Winter',
                'poster' => 'Winter.png',
            ]);
            AZRestaurantPoster::create([
                'restaurant_id' => $restaurant->id,
                'name_ar' => 'رجل الثلج',
                'name_en' => 'Ice man',
                'poster' => 'Ice_man.png',
            ]);
            AZRestaurantPoster::create([
                'restaurant_id' => $restaurant->id,
                'name_ar' => 'سبايسي',
                'name_en' => 'Spicy',
                'poster' => 'Spicy.png',
            ]);
            AZRestaurantPoster::create([
                'restaurant_id' => $restaurant->id,
                'name_ar' => 'جديد (عربي)',
                'name_en' => 'New (Arabic)',
                'poster' => 'gdeed.png',
            ]);
        }
    }
}
