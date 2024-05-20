<?php

namespace App\Models\Restaurant\Azmak;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AZRestaurantColor extends Model
{
    use HasFactory;

    protected $table = 'a_z_restaurant_colors';
    protected $fillable = [
        'restaurant_id',
        'main_heads',
        'icons',
        'options_description',
        'background',
        'product_background',
        'category_background',
    ];

    public function restaurant()
    {
        return $this->belongsTo(Restaurant::class , 'restaurant_id');
    }
}
