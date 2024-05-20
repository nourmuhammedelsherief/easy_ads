<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EasyAdsSubscription extends Model
{
    use HasFactory;
    protected $table = 'easy_ads_subscriptions';
    protected $fillable = [
        'restaurant_id',
        'seller_code_id',
        'bank_id',
        'status',
        'subscription_type',
        'payment_type',
        'payment',
        'tax_value',
        'discount_value',
        'price',
        'end_at',
        'transfer_photo',
        'invoice_id',
    ];

    protected $casts = ['end_at' => 'datetime'];

    public function restaurant()
    {
        return $this->belongsTo(Restaurant::class , 'restaurant_id');
    }
    public function seller_code()
    {
        return $this->belongsTo(EasyAdsSellerCode::class , 'seller_code_id');
    }
    public function bank()
    {
        return $this->belongsTo(Bank::class , 'bank_id');
    }
}
