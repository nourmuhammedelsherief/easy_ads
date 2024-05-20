<?php

namespace App\Models\Restaurant\Azmak;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use \App\Models\Restaurant;
use \App\Models\AZRestaurantPoster;
use \App\Models\AZRestaurantSensitivity;

class AZProduct extends Model
{
    use HasFactory;
    protected $table = 'a_z_products';
    protected $fillable = [
        'restaurant_id',
        'branch_id',
        'menu_category_id',
        'sub_category_id',
        'poster_id',
        'name_ar',
        'name_en',
        'active',
        'description_ar',
        'description_en',
        'time',
        'start_at',
        'end_at',
        'photo',
        'available',
        'price',
        'price_before_discount',
        'calories',
        'arrange',
        'video_type',
        'video_id',
    ];

    public function restaurant()
    {
        return $this->belongsTo(Restaurant::class , 'restaurant_id');
    }
    public function branch()
    {
        return $this->belongsTo(AZBranch::class , 'branch_id');
    }
    public function menu_category()
    {
        return $this->belongsTo(AZMenuCategory::class , 'menu_category_id');
    }
    public function sub_category()
    {
        return $this->belongsTo(AZRestaurantSubCategory::class , 'sub_category_id');
    }
    public function poster()
    {
        return $this->belongsTo(AZRestaurantPoster::class , 'poster_id');
    }
    public function modifiers()
    {
        return $this->hasMany(AZProductModifier::class , 'product_id');
    }
    public function options()
    {
        return $this->hasMany(AZProductOption::class , 'product_id');
    }
    public function sizes()
    {
        return $this->hasMany(AZProductSize::class , 'product_id');
    }
    public function sensitivities()
    {
        return $this->hasMany(AZProductSensitivity::class , 'product_id');
    }
}
