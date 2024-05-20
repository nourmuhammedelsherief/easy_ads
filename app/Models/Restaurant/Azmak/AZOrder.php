<?php

namespace App\Models\Restaurant\Azmak;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Restaurant;

class AZOrder extends Model
{
    use HasFactory;

    protected $table = 'a_z_orders';
    protected $fillable = [
        'restaurant_id',
        'branch_id',
        'user_id',
        'order_id',
        'status',
        'notes',
        'order_price',
        'tax',
        'discount',
        'total_price',
        'invoice_id',
        'person_name',
        'person_phone',
        'occasion',
        'occasion_message',
        'order_code',
        'commission',
        'cancel_reason',
    ];
    public function restaurant()
    {
        return $this->belongsTo(Restaurant::class , 'restaurant_id');
    }
    public function branch()
    {
        return $this->belongsTo(AZBranch::class , 'branch_id');
    }
    public function user()
    {
        return $this->belongsTo(AZUser::class , 'user_id');
    }
    public function items()
    {
        return $this->hasMany(AZOrderItem::class , 'order_id');
    }
}
