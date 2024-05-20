<?php

namespace App\Models\Restaurant\Azmak;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AZOrderItem extends Model
{
    use HasFactory;
    protected $table = 'a_z_order_items';
    protected $fillable = [
        'order_id',
        'product_id',
        'size_id',
        'product_count',
        'price',
    ];
    public function order()
    {
        return $this->belongsTo(AZOrder::class , 'order_id');
    }
    public function product()
    {
        return $this->belongsTo(AZProduct::class , 'product_id');
    }
    public function size()
    {
        return $this->belongsTo(AZProductSize::class , 'size_id');
    }
    public function options()
    {
        return $this->hasMany(AZOrderItemOption::class , 'item_id');
    }
}
