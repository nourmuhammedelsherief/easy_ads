<?php

namespace App\Models;

use App\Models\Restaurant\Azmak\AZProduct;
use App\Models\Restaurant\Azmak\AZBranch;
use App\Models\Restaurant\Azmak\AZOrder;
use App\Models\Restaurant\Azmak\AZRestaurantInfo;
use App\Models\Restaurant\Azmak\AZRestaurantColor;
use App\Models\Restaurant\Azmak\AZMenuCategory;
use App\Models\AzRestaurantCommission;
use Carbon\Carbon;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;


class Restaurant extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $guard = 'restaurant';
    protected $table = 'restaurants';
    protected $fillable = [
        'restaurant_id',
        'name_ar',
        'name_en',
        'country_id',
        'city_id',
        'package_id',
        'phone_number',
        'email',
        'password',
        'phone_verification',
        'latitude',
        'longitude',
        'status',     //ENUM( 'inComplete','tentative','active','finished' ),
        'logo',
        'ar',    // true , false
        'en',    // true , false
        'archive',    // true , false
        'cart',    // true , false
        'name_barcode', // the name used for barcode,
        'menu_arrange',
        'product_arrange',
        'total_tax_price',
        'tax_value',
        'tax',
        'information_ar',
        'information_en',
        'description_ar',
        'description_en',
        'views',
        'myfatoora_token',
        'show_branches_list',
        'menu',        // ENUM('vertical','horizontal'),
        'state',       // ENUM('open','closed','busy' , 'un_available')
        'enable_bank', // Emun (true,false)
        'enable_online_payment', // Emun (true,false)
        'answer_id',
        'orders',
        'default_lang',
        'is_call_phone', //true , false
        'is_whatsapp', //true , false
        'call_phone',
        'whatsapp_number',
        'payment_company',
        'online_token',
        'theme_id',
        'archive_category_id',
        'merchant_key',
        'express_password',
        'stop_menu',
        'admin_activation',
        'type',   // restaurant , employee
        'online_payment_fees',
        'last_session',
        'reservation_to_restaurant', // true , false
        'last_activity',
        'header',
        'footer',
        'sms_method', // enum [taqnyat]
        'sms_sender',  'sms_token',
        'slider_down_contact_us_title',
        'archive_reason', 'archived_by_id',
        'product_menu_view',
        'a_z_orders_payment_type',
        'a_z_tap_token',
        'a_z_myFatoourah_token',
        'a_z_edfa_merchant',
        'a_z_edfa_password',
        'az_logo',
        'az_commission',
        'az_online_payment_type',
        'maximum_az_commission_limit',
        'pay_link_app_id',
        'pay_link_secret_key',
    ];
    protected $hidden = [
        'password', 'remember_token',
    ];
    protected $casts = [
        'waiting_new_request' => 'json',
    ];
    public function getImagePathAttribute()
    {
        return 'uploads/restaurants/logo/' . $this->logo;
    }

    public function archiveBy()
    {
        return $this->belongsTo(Admin::class, 'archived_by_id');
    }
    public function country()
    {
        return $this->belongsTo(Country::class, 'country_id');
    }
    public function city()
    {
        return $this->belongsTo(City::class, 'city_id');
    }
    public function sliders()
    {
        return $this->hasMany(AzRestaurantSlider::class, 'restaurant_id');
    }

    public function banks()
    {
        return $this->hasMany(Bank::class, 'restaurant_id');
    }


    public function histories()
    {
        return $this->hasMany(History::class, 'restaurant_id');
    }

    public function posters()
    {
        return $this->hasMany(AZRestaurantPoster::class, 'restaurant_id');
    }

    public function ads_subscription()
    {
        return $this->hasOne(EasyAdsSubscription::class , 'restaurant_id');
    }

    public function az_color()
    {
        return $this->hasOne(AZRestaurantColor::class , 'restaurant_id');
    }
    public function users()
    {
        return $this->hasMany(AzRestaurantUser::class , 'restaurant_id');
    }
}
