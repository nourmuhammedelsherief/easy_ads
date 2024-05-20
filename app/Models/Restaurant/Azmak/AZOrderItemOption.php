<?php

namespace App\Models\Restaurant\Azmak;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AZOrderItemOption extends Model
{
    use HasFactory;
    protected $table = 'a_z_order_item_options';
    protected $fillable = [
        'item_id',
        'option_id',
        'option_count',
    ];

    public function item()
    {
        return $this->belongsTo(AZOrderItem::class , 'item_id');
    }
    public function option()
    {
        return $this->belongsTo(AZOption::class , 'option_id');
    }
}
