<?php

namespace App\Models\Restaurant\Azmak;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Restaurant;

class AZRestaurantInfo extends Model
{
    use HasFactory;
    protected $table = 'a_z_restaurant_infos';
    protected $fillable = [
        'restaurant_id',
        'menu_show_type',
        'description_ar',
        'description_en',
        'lang',
        'commission_payment',
        'menu_views',
    ];

    public function restaurant()
    {
        return $this->belongsTo(Restaurant::class , 'restaurant_id');
    }
}
