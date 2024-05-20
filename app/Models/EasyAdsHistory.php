<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EasyAdsHistory extends Model
{
    use HasFactory;
    protected $table = 'easy_ads_histories';
    protected $fillable = [
        'restaurant_id',
        'seller_code_id',
        'bank_id',
        'admin_id',
        'payment_type',
        'subscription_type',
        'transfer_photo',
        'invoice_id',
        'paid_amount',
        'tax',
        'discount',
        'details',
    ];

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
    public function admin()
    {
        return $this->belongsTo(Admin::class , 'admin_id');
    }
}
