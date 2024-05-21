<?php

use App\Http\Controllers\Controller;
use App\Models\Branch;
use App\Models\Country;
use App\Models\FoodicsLog;
use App\Models\Poster;
use App\Models\Product;
use App\Models\ProductOption;
use App\Models\Restaurant;
use App\Models\RestaurantEmployee;
use App\Models\RestaurantFoodicsBranch;
use App\Models\RestaurantSensitivity;
use App\Models\RestaurantSlider;
use App\Models\Sensitivity;
use LaravelFCM\Message\OptionsBuilder;
use LaravelFCM\Message\PayloadDataBuilder;
use LaravelFCM\Message\PayloadNotificationBuilder;
use LaravelFCM\Facades\FCM;
use App\Models\Setting;
use App\Models\SilverOrderFoodics;
use App\Models\SmsHistory;
use App\Models\TableOrder;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\EasyAdsSetting;

$restaurantId = null;


function randNumber($length)
{

    $seed = str_split('0123456789');

    shuffle($seed);

    $rand = '';

    foreach (array_rand($seed, $length) as $k) $rand .= $seed[$k];

    return $rand;
}

function generateApiToken($userId, $length)
{

    $seed = str_split('abcdefghijklmnopqrstuvwxyz' . 'ABCDEFGHIJKLMNOPQRSTUVWXYZ' . '0123456789');

    shuffle($seed);

    $rand = '';

    foreach (array_rand($seed, $length) as $k) $rand .= $seed[$k];

    return $userId * $userId . $rand;
}

function UploadBase64Image($base64Str, $prefix, $folderName)
{

    $image = base64_decode($base64Str);
    $image_name = $prefix . '_' . time() . '.png';
    $path = public_path('uploads') . DIRECTORY_SEPARATOR . $folderName . DIRECTORY_SEPARATOR . $image_name;

    $saved = file_put_contents($path, $image);

    return $saved ? $image_name : NULL;
}

function UploadImage($inputRequest, $prefix, $folderNam)
{

    if (in_array($inputRequest->getClientOriginalExtension(), ['gif'])) :
        return basename(Storage::disk('public_storage')->put($folderNam, $inputRequest));
    endif;
    $folderPath = public_path($folderNam);
    if (!File::isDirectory($folderPath)) {

        File::makeDirectory($folderPath, 0777, true, true);
    }
    $image = time() . '' . rand(11111, 99999) . '.' . $inputRequest->getClientOriginalExtension();
    $destinationPath = public_path('/' . $folderNam);
    $img = Image::make($inputRequest->getRealPath());
    $img->resize(500, 500, function ($constraint) {
        $constraint->aspectRatio();
    })->save($destinationPath . '/' . $image);

    return $image ? $image : false;
}

function copyImage($filename, $prefix, $folderNam)
{
    if (!Storage::disk('public_storage')->exists($filename)) return '';
    $temp = explode('.', $filename);
    $ext = $temp[count($temp) - 1];
    $image = 'copy_' . time() . '' . rand(11111, 99999) . '.' . $ext;
    $destinationPath = public_path('/' . $folderNam);
    if (!Storage::disk('public_storage')->exists($folderNam)) :
        File::isDirectory($destinationPath) or File::makeDirectory($destinationPath, 0777, true, true);
    endif;
    $img = Image::make(public_path($filename));
    $img->save($destinationPath . '/' . $image);

    return $image ? $image : false;
}

function UploadFile($inputRequest, $prefix, $folderNam)
{

    $imageName = $prefix . '_' . time() . '.' . $inputRequest->getClientOriginalExtension();

    $destinationPath = public_path('/' . $folderNam);
    $inputRequest->move($destinationPath, $imageName);
    // dd($destinationPath);

    return $imageName ? $imageName : false;
}

function UploadFileEdit($inputRequest, $prefix, $folderNam, $old = null)
{
    if ($old) {
        @unlink(public_path('/uploads/files/' . $old));
    }

    $imageName = $prefix . '_' . time() . '.' . $inputRequest->getClientOriginalExtension();

    $destinationPath = public_path('/' . $folderNam);
    $inputRequest->move($destinationPath, $imageName);
    // dd($destinationPath);

    return $imageName ? $imageName : false;
}

function UploadVideo($file)
{
    if ($file) {
        $filename = $file->getClientOriginalName();
        $path = public_path() . '/uploads/videos';
        $file->move($path, $filename);
        return $filename;
    }
}

function UploadVideoEdit($file, $old)
{
    if ($old) {
        @unlink(public_path('/uploads/videos/' . $old));
    }
    if ($file) {
        $filename = $file->getClientOriginalName();
        $path = public_path() . '/uploads/videos';
        $file->move($path, $filename);
        return $filename;
    }
}

function UploadImageEdit($inputRequest, $prefix, $folderNam, $oldImage, $height = null, $width = 1500)
{
    $fixed_images = array('default_logo.jpg', 'default1.png', 'default2.png', 'fish.png', 'egg.png', 'seeds.png', 'jamp.png', 'milk.png', 'ghrdl.png', 'rghoyat.png', 'foul.png', 'kbret.png', 'krfs.png', 'mksrat.png', 'soya.png', 'trms.png', 'best.png', 'new.png', 'Best_selling.png', 'New1.png', 'Chef.png', 'Offer.png', 'Coming_soon.png', 'Coming_soon1.png', 'Ice.png', 'Winter.png', 'Ice_man.png', 'Spicy.png', 'gdeed.png', 'default.jpg');
    if (!in_array($oldImage, $fixed_images)) {
        @unlink(public_path('/' . $folderNam . '/' . $oldImage));
    }

    $path = public_path() . $folderNam;
    if (!file_exists($path)) :
        File::isDirectory($path) or File::makeDirectory($path, 0777, true, true);
    endif;
    if (in_array($inputRequest->getClientOriginalExtension(), ['gif'])) {
        return basename(Storage::disk('public_storage')->put($folderNam, $inputRequest));
    }
    $image = time() . '' . rand(11111, 99999) . '.' . $inputRequest->getClientOriginalExtension();
    $destinationPath = public_path('/' . $folderNam);
    $img = Image::make($inputRequest->getRealPath());
    $img->resize($height, $width, function ($constraint) {
        $constraint->aspectRatio();
        // $constraint->upsize();
    })->save($destinationPath . '/' . $image);
    return $image ? $image : false;
}


function sendNotification($notificationTitle, $notificationBody, $deviceToken)
{

    $optionBuilder = new OptionsBuilder();
    $optionBuilder->setTimeToLive(60 * 20);

    $notificationBuilder = new PayloadNotificationBuilder($notificationTitle);
    $notificationBuilder->setBody($notificationBody)
        ->setSound('default');

    $dataBuilder = new PayloadDataBuilder();
    $dataBuilder->addData(['a_data' => 'my_data']);

    $option = $optionBuilder->build();
    $notification = $notificationBuilder->build();
    $data = $dataBuilder->build();

    $token = $deviceToken;

    $downstreamResponse = FCM::sendTo($token, $option, $notification, $data);

    $downstreamResponse->numberSuccess();
    $downstreamResponse->numberFailure();
    $downstreamResponse->numberModification();

    //return Array - you must remove all this tokens in your database
    $downstreamResponse->tokensToDelete();

    //return Array (key : oldToken, value : new token - you must change the token in your database )
    $downstreamResponse->tokensToModify();

    //return Array - you should try to resend the message to the tokens in the array
    $downstreamResponse->tokensToRetry();

    // return Array (key:token, value:errror) - in production you should remove from your database the tokens
}

function sendMultiNotification($notificationTitle, $notificationBody, $devicesTokens)
{

    $optionBuilder = new OptionsBuilder();
    $optionBuilder->setTimeToLive(60 * 20);

    $notificationBuilder = new PayloadNotificationBuilder($notificationTitle);
    $notificationBuilder->setBody($notificationBody)
        ->setSound('default');

    $dataBuilder = new PayloadDataBuilder();
    $dataBuilder->addData(['a_data' => 'my_data']);

    $option = $optionBuilder->build();
    $notification = $notificationBuilder->build();
    $data = $dataBuilder->build();

    // You must change it to get your tokens
    $tokens = $devicesTokens;

    $downstreamResponse = FCM::sendTo($tokens, $option, $notification, $data);

    $downstreamResponse->numberSuccess();
    $downstreamResponse->numberFailure();
    $downstreamResponse->numberModification();

    //return Array - you must remove all this tokens in your database
    $downstreamResponse->tokensToDelete();

    //return Array (key : oldToken, value : new token - you must change the token in your database )
    $downstreamResponse->tokensToModify();

    //return Array - you should try to resend the message to the tokens in the array
    $downstreamResponse->tokensToRetry();

    // return Array (key:token, value:errror) - in production you should remove from your database the tokens present in this array
    $downstreamResponse->tokensWithError();

    return ['success' => $downstreamResponse->numberSuccess(), 'fail' => $downstreamResponse->numberFailure()];
}

function saveNotification($userId, $title, $message, $type, $order_id = null, $device_token = null)
{

    $created = \App\UserNotification::create([
        'user_id' => $userId,
        'title' => $title,
        'type' => $type,
        'message' => $message,
        'order_id' => $order_id,
        'device_token' => $device_token,
    ]);
    return $created;
}

function check_time_between($start_at, $end_at)
{
    if ($start_at == null and $end_at == null) {
        return true;
    }
    $now = \Carbon\Carbon::now()->format('H:i:s');
    if ($start_at > $end_at) {
        // the end at another day
        if ($start_at < $now) {
            $start = \Carbon\Carbon::now()->format('Y-m-d' . ' ' . $start_at);
            $end = \Carbon\Carbon::now()->addDay()->format('Y-m-d' . ' ' . $end_at);
            $check = \Carbon\Carbon::now()->between($start, $end, true);
        } else {
            $start = \Carbon\Carbon::now()->addDays(-1)->format('Y-m-d' . ' ' . $start_at);
            $end = \Carbon\Carbon::now()->format('Y-m-d' . ' ' . $end_at);
            $check = \Carbon\Carbon::now()->between($start, $end, true);
        }
    } else {
        $start = \Carbon\Carbon::now()->format('Y-m-d' . ' ' . $start_at);
        $end = \Carbon\Carbon::now()->format('Y-m-d' . ' ' . $end_at);
        $check = \Carbon\Carbon::now()->between($start, $end, true);
    }
    return $check;
}


####### Check Payment Status ######
function MyFatoorahStatus($api, $PaymentId)
{
    // dd($PaymentId);
    $token = $api;
    $setting = EasyAdsSetting::first();
    if ($setting->online_payment_type == 'test' or substr($token, 0, 10) == 'rLtt6JWvbU') {
        $basURL = "https://apitest.myfatoorah.com/";
    } else {
        $basURL = "https://api-sa.myfatoorah.com/";
    }
    $curl = curl_init();
    curl_setopt_array($curl, array(
        CURLOPT_URL => "$basURL/v2/GetPaymentStatus",
        CURLOPT_CUSTOMREQUEST => "POST",
        CURLOPT_POSTFIELDS => "{\"Key\": \"$PaymentId\",\"KeyType\": \"PaymentId\"}",
        CURLOPT_HTTPHEADER => array("Authorization: Bearer $token", "Content-Type: application/json"),
    ));
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($curl);
    $err = curl_error($curl);
    curl_close($curl);
    if ($err) {
        return $err;
    } else {
        return $response;
    }
}

// ===============================  MyFatoorah public  function  =========================
function MyFatoorah($api, $userData)
{
    $setting = EasyAdsSetting::first();
    $token = $api;
    if ($setting->online_payment_type == 'test' or substr($token, 0, 10) == 'rLtt6JWvbU') {
        $basURL = "https://apitest.myfatoorah.com/";
    } else {
        $basURL = "https://api-sa.myfatoorah.com/";
    }
    $curl = curl_init();
    curl_setopt_array($curl, array(
        CURLOPT_URL => "$basURL/v2/ExecutePayment",
        CURLOPT_CUSTOMREQUEST => "POST",
        CURLOPT_POSTFIELDS => $userData,
        CURLOPT_HTTPHEADER => array("Authorization: Bearer $token", "Content-Type: application/json"),
    ));
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($curl);
    $err = curl_error($curl);
    curl_close($curl);
    if ($err) {
        return $err;
    } else {
        return $response;
    }
}

/**
 * calculate the distance between tow places on the earth
 *
 * @param latitude $latitudeFrom
 * @param longitude $longitudeFrom
 * @param latitude $latitudeTo
 * @param longitude $longitudeTo
 * @return double distance in KM
 */
function distanceBetweenTowPlaces($latitudeFrom, $longitudeFrom, $latitudeTo, $longitudeTo)
{
    $long1 = deg2rad($longitudeFrom);
    $long2 = deg2rad($longitudeTo);
    $lat1 = deg2rad($latitudeFrom);
    $lat2 = deg2rad($latitudeTo);
    //Haversine Formula
    $dlong = $long2 - $long1;
    $dlati = $lat2 - $lat1;
    $val = pow(sin($dlati / 2), 2) + cos($lat1) * cos($lat2) * pow(sin($dlong / 2), 2);
    $res = 2 * asin(sqrt($val));
    $radius = 6367.756;
    return ($res * $radius);
}


/**
 *  Taqnyat sms to send message
 */
function taqnyatSms($msgBody, $reciver)
{
    $setting = Setting::find(1);
    $bearer = $setting->bearer_token;
    $sender = $setting->sender_name;
    $taqnyt = new TaqnyatSms($bearer);

    $body = $msgBody;
    $recipients = $reciver;
    $message = $taqnyt->sendMsg($body, $recipients, $sender);
    return $message;
}

function checkOrderService($restaurant_id, $service_id, $branch_id = null)
{
    if ($branch_id) {
        $service = \App\Models\ServiceSubscription::whereRestaurantId($restaurant_id)
            ->where('service_id', $service_id)
            ->whereIn('status', ['active', 'tentative'])
            ->whereBranchId($branch_id)
            ->first();
    } else {
        $service = \App\Models\ServiceSubscription::whereRestaurantId($restaurant_id)
            ->where('service_id', $service_id)
            ->whereIn('status', ['active', 'tentative'])
            ->first();
    }
    return !($service == null) ? true : false;
}

function checkOrderSetting($restaurant_id, $type, $branch_id = null)
{
    if ($branch_id) {
        $setting = \App\Models\RestaurantOrderSetting::whereRestaurantId($restaurant_id)
            ->where('order_type', $type)
            ->whereBranchId($branch_id)
            ->first();
    } else {
        $setting = \App\Models\RestaurantOrderSetting::whereRestaurantId($restaurant_id)
            ->where('order_type', $type)
            ->first();
    }
    return !($setting == null) ? true : false;
}


function check_branch_periods($id)
{
    $branch = \App\Models\Branch::find($id);
    // check if the branch has periods or not
    $current_day = \Carbon\Carbon::now()->format('l');
    $day = \App\Models\Day::whereNameEn($current_day)->first()->id;
    $periods = \App\Models\RestaurantPeriod::with('days')
        ->whereHas('days', function ($q) use ($day) {
            $q->where('day_id', $day);
        })
        ->where('restaurant_id', $branch->restaurant_id)
        ->where('branch_id', $branch->id)
        ->get();
    if ($periods->count() > 0) {
        foreach ($periods as $period) {
            $state = check_time_between($period->start_at, $period->end_at);
            if ($state == true) {
                return $state;
            }
        }
        return false;
    } else {
        $check_period = \App\Models\RestaurantPeriod::where('restaurant_id', $branch->restaurant_id)
            ->where('branch_id', $branch->id)
            ->count();
        return $check_period > 0 ? false : true;
    }
}

function check_restaurant_permission($res_id, $permission_id)
{
    $permission = \App\Models\RestaurantPermission::whereRestaurantId($res_id)
        ->wherePermissionId($permission_id)
        ->first();
    return !($permission == null) ? true : false;
}


function auth_paymob()
{
    $basURL = "https://accept.paymob.com/api/auth/tokens";
    $headers = array(
        'Content-type: application/json',
        'Accept: application/json',
    );

    $order = array(
        "api_key" => "ZXlKaGJHY2lPaUpJVXpVeE1pSXNJblI1Y0NJNklrcFhWQ0o5LmV5SmpiR0Z6Y3lJNklrMWxjbU5vWVc1MElpd2libUZ0WlNJNklqRTJOVGd6TWpjeE9URXVNamczT1RreElpd2ljSEp2Wm1sc1pWOXdheUk2TWpRd05UWTRmUS5Zb1lOY3ZOenN6aVltLS1WaDlnalFVdzR5dDk4N3U0Q0hwalZJVVpoallvNmdST1lPVlpBNW1feDQzLWZjdlY2ME1VejhCTXM0VFdLaWtvQmN4UWZLQQ=="
    );
    $order = json_encode($order);
    $curl = curl_init();
    curl_setopt_array($curl, array(
        CURLOPT_URL => $basURL,
        CURLOPT_CUSTOMREQUEST => "POST",
        CURLOPT_POSTFIELDS => $order,
        CURLOPT_HTTPHEADER => $headers,
    ));
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($curl);
    $err = curl_error($curl);
    curl_close($curl);
    if ($err) {
        return $err;
    } else {
        dd($response);
        return $response;
    }
}

function paymob()
{
    $basURL = "https://accept.paymob.com/api/ecommerce/orders";
    $headers = array(
        'Content-type: application/json',
        'Accept: application/json',
    );

    $order = array(
        "auth_token" => "ZXlKaGJHY2lPaUpJVXpVeE1pSXNJblI1Y0NJNklrcFhWQ0o5LmV5SmpiR0Z6Y3lJNklrMWxjbU5vWVc1MElpd2ljR2hoYzJnaU9pSmpZelV5TTJFNVptVXdZVFEzTmpCbFlqTm1NRFkyWkRReU9XSXdabVppWXpabU1EUXlOemhqWWpoak16SXhOV0ZqTkdSaFpUUTJNV0ZqTldFd1lUVmpJaXdpWlhod0lqb3hOalU0TXpNM05qSTJMQ0p3Y205bWFXeGxYM0JySWpveU5EQTFOamg5LjhxTDUxV0VIeUsxNUZHZWxMd09rWU9mTHJFSEdsdU1jY2JmYjNCcjZuNG5HY21rT0NuaWpYU3lWdHhSZFl6RFc4QW9nRnlIeENVT2J4WGtvcEZPVG1R",
        "delivery_needed" => "false",
        "amount_cents" => "100",
        "currency" => "EGP",
        "merchant_order_id" => 10045,
        "items" => array(
            array(
                "name" => "ASC1515",
                "amount_cents" => "500000",
                "description" => "Smart Watch",
                "quantity" => "1"
            ),
        ),
        "shipping_data" => array(
            "apartment" => "803",
            "email" => "claudette09@exa.com",
            "floor" => "42",
            "first_name" => "Clifford",
            "street" => "Ethan Land",
            "building" => "8028",
            "phone_number" => "+86(8)9135210487",
            "postal_code" => "01898",
            "extra_description" => "8 Ram , 128 Giga",
            "city" => "Jaskolskiburgh",
            "country" => "CR",
            "last_name" => "Nicolas",
            "state" => "Utah"
        ),
        "shipping_details" => array(
            "notes" => " test",
            "number_of_packages" => 1,
            "weight" => 1,
            "weight_unit" => "Kilogram",
            "length" => 1,
            "width" => 1,
            "height" => 1,
            "contents" => "product of some sorts"
        )
    );
    $order = json_encode($order);
    $curl = curl_init();
    curl_setopt_array($curl, array(
        CURLOPT_URL => $basURL,
        CURLOPT_CUSTOMREQUEST => "POST",
        CURLOPT_POSTFIELDS => $order,
        CURLOPT_HTTPHEADER => $headers,
    ));
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($curl);
    $err = curl_error($curl);
    curl_close($curl);
    if ($err) {
        return $err;
    } else {
        $response = array_values(json_decode($response, true));
        dd($response);
        return $response;
    }
}



/**
 * Check if a given URL is currently active based on specified conditions.
 *
 * @param string $url The URL to check against.
 * @param bool $checkFull Whether to check for a full match (including query parameters).
 * @param array $data Additional data to check against request parameters.
 *
 * @return bool Returns true if the URL is active; otherwise, false.
 */

function tap_payment($token = 'sk_test_XKokBfNWv6FIYuTMg5sLPjhJ', $amount, $user_name, $email, $country_code, $phone, $callBackUrl, $order_id)
{
    $basURL = "https://api.tap.company/v2/charges";
    $headers = array(
        'Content-type: application/json',
        'Accept: application/json',
        'Authorization: Bearer ' . $token,
    );

    $data = array(
        "amount" => $amount,
        "currency" => "SAR",
        "customer" => array(
            "first_name" => $user_name,
            "email" => $email,
            "phone" => array(
                "country_code" => $country_code,
                "number" => $phone
            ),
        ),
        "source" => array(
            "id" => "src_card"
        ),
        "redirect" => array(
            "url" => $callBackUrl,
        )
    );
    $order = json_encode($data);
    $curl = curl_init();
    curl_setopt_array($curl, array(
        CURLOPT_URL => $basURL,
        CURLOPT_CUSTOMREQUEST => "POST",
        CURLOPT_POSTFIELDS => $order,
        CURLOPT_HTTPHEADER => $headers,
    ));
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($curl);
    $err = curl_error($curl);
    curl_close($curl);

    if ($err) {
        return $err;
    } else {
        $response = json_decode($response);
        return $response->transaction->url;
    }
}



function deleteImageFile($path)
{
    if (!empty($path) and Storage::disk('public_storage')->exists($path)) :
        Storage::disk('public_storage')->delete($path);
        return true;
    endif;

    return false;
}

function getTaqnyatPhones($phones)
{
    $items = explode(',', $phones);
    $list = [];
    foreach ($items as $item) :
        $check = substr($item, 0, 2) === "05";
        if ($check == true) {
            $phone = '00966' . ltrim($item, '0');
        } elseif (substr($item, 0, 3) === "010") {
            $phone = '002' . $item;
        } else {
            $phone = $item;
        }
        $list[] = $phone;
    endforeach;
    return $list;
    return implode(',', $list);
}

function edfa_payment($merchant_key, $password, $amount, $success_url, $order_id, $user_name, $email)
{
    $currency = 'SAR';
    $order_description = 'pay order value';
    $str_to_hash = $order_id . $amount . $currency . $order_description . $password;
    $hash = sha1(md5(strtoupper($str_to_hash)));
    $main_req = array(
        'action' => 'SALE',
        'edfa_merchant_id' => $merchant_key,
        'order_id' => "$order_id",
        'order_amount' => $amount,
        'order_currency' => $currency,
        'order_description' => $order_description,
        'req_token' => 'N',
        'payer_first_name' => $user_name,
        'payer_last_name' => $user_name,
        'payer_address' => $email,
        'payer_country' => 'SA',
        'payer_city' => 'Riyadh',
        'payer_zip' => '12221',
        'payer_email' => $email,
        'payer_phone' => '966525789635',
        'payer_ip' => '127.0.0.1',
        'term_url_3ds' => $success_url,
        'auth' => 'N',
        'recurring_init' => 'N',
        'hash' => $hash,
    );

    $getter = curl_init('https://api.edfapay.com/payment/initiate'); //init curl
    curl_setopt($getter, CURLOPT_POST, 1); //post
    curl_setopt($getter, CURLOPT_POSTFIELDS, $main_req);
    curl_setopt($getter, CURLOPT_RETURNTRANSFER, true);

    $result = curl_exec($getter);
    $httpcode = curl_getinfo($getter, CURLINFO_HTTP_CODE);
    $result = json_decode($result);
    return $result->redirect_url;
}

function payLinkToken($type,$appId , $secretKey)
{
    $basURL = ($type == 'test' ? "https://restpilot.paylink.sa" : "https://restapi.paylink.sa") . "/api/auth";
    $headers = array(
        'Content-type: application/json',
        'Accept: application/json',
    );

    $data = array(
        "apiId" => $appId,
        "secretKey" => $secretKey,
        "persistToken" => "false"
    );
    $order = json_encode($data);
    $curl = curl_init();
    curl_setopt_array($curl, array(
        CURLOPT_URL => $basURL,
        CURLOPT_CUSTOMREQUEST => "POST",
        CURLOPT_POSTFIELDS => $order,
        CURLOPT_HTTPHEADER => $headers,
    ));
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($curl);
    $err = curl_error($curl);
    curl_close($curl);

    if ($err) {
        return $err;
    } else {
        $response = json_decode($response);
        return $response->id_token;
    }
}

function payLinkAddInvoice($amount , $email,$phone,$name,$orderNo,$url)
{
    $setting = EasyAdsSetting::first();
    $basURL = ($setting->pay_link_payment_type == 'test' ? "https://restpilot.paylink.sa" : "https://restapi.paylink.sa") . "/api/addInvoice";
    $token = payLinkToken($setting->online_payment_type , $setting->pay_link_app_id , $setting->pay_link_secret_key);
    $headers = array(
        'Content-type: application/json',
        'Accept: application/json',
        'Authorization: Bearer ' . $token,
    );

    $data = array(
        "amount" => $amount,
        "callBackUrl" => $url,
        "clientEmail" => $email,
        "clientMobile" => $phone,
        "clientName" => $name,
        "note" => "This invoice is for VIP client.",
        "orderNumber" => $orderNo,
        "products" => array(
            array(
                "description" => "Brown Hand bag leather for ladies",
                "imageSrc" => "http://merchantwebsite.com/img/img1.jpg",
                "isDigital" => true,
                "price" => $amount,
                "qty" => 1,
                "title" => "Hand bag"
            )
        ),
    );

    $order = json_encode($data);
    $curl = curl_init();
    curl_setopt_array($curl, array(
        CURLOPT_URL => $basURL,
        CURLOPT_CUSTOMREQUEST => "POST",
        CURLOPT_POSTFIELDS => $order,
        CURLOPT_HTTPHEADER => $headers,
    ));
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($curl);
    $err = curl_error($curl);
    curl_close($curl);

    if ($err) {
        return $err;
    } else {
        $response = json_decode($response);
        Restaurant::whereEmail($email)->first()->ads_subscription->update(['invoice_id' => $response->transactionNo]);
        return $response->url;
    }
}
function payLinkAddInvoiceOrders($restaurant , $amount , $email,$phone,$name,$orderNo,$url)
{
    $basURL = ($restaurant->pay_link_app_id == 'APP_ID_1123453311' ? "https://restpilot.paylink.sa" : "https://restapi.paylink.sa") . "/api/addInvoice";
    $token = payLinkToken(($restaurant->pay_link_app_id == 'APP_ID_1123453311' ? 'test' : 'online') , $restaurant->pay_link_app_id , $restaurant->pay_link_secret_key);
    $headers = array(
        'Content-type: application/json',
        'Accept: application/json',
        'Authorization: Bearer ' . $token,
    );

    $data = array(
        "amount" => $amount,
        "callBackUrl" => $url,
        "clientEmail" => $email,
        "clientMobile" => $phone,
        "clientName" => $name,
        "note" => "This invoice is for VIP client.",
        "orderNumber" => $orderNo,
        "products" => array(
            array(
                "description" => "Brown Hand bag leather for ladies",
                "imageSrc" => "http://merchantwebsite.com/img/img1.jpg",
                "isDigital" => true,
                "price" => $amount,
                "qty" => 1,
                "title" => "Hand bag"
            )
        ),
    );

    $order = json_encode($data);
    $curl = curl_init();
    curl_setopt_array($curl, array(
        CURLOPT_URL => $basURL,
        CURLOPT_CUSTOMREQUEST => "POST",
        CURLOPT_POSTFIELDS => $order,
        CURLOPT_HTTPHEADER => $headers,
    ));
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($curl);
    $err = curl_error($curl);
    curl_close($curl);

    if ($err) {
        return $err;
    } else {
        $response = json_decode($response);
        return $response->url;
    }
}
