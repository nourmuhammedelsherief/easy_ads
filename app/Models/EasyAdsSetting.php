<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EasyAdsSetting extends Model
{
    use HasFactory;
    protected $table = 'easy_ads_settings';
    protected $fillable = [
        'subscription_type',
        'subscription_amount',
        'tax',
        'bank_transfer',
        'online_payment',
        'online_payment_type',
        'myFatoourah_token',
        'pay_link_app_id',
        'pay_link_secret_key',
    ];
}
