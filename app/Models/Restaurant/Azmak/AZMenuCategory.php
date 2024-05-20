<?php

namespace App\Models\Restaurant\Azmak;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use \App\Models\Restaurant;
use \App\Models\AZRestaurantPoster;


class AZMenuCategory extends Model
{
    use HasFactory;
    protected $table = 'a_z_menu_categories';
    protected $fillable = [
        'restaurant_id',
        'branch_id',
        'name_ar',
        'name_en',
        'photo',
        'active',
        'arrange',
        'description_ar',
        'description_en',
        'foodics_image',
        'foodics_id',
        'time',
        'start_at',
        'end_at',
        'poster_id',
    ];

    public function restaurant()
    {
        return $this->belongsTo(Restaurant::class , 'restaurant_id');
    }
    public function branch()
    {
        return $this->belongsTo(AZBranch::class , 'branch_id');
    }
    public function sub_categories()
    {
        return $this->hasMany(AZRestaurantSubCategory::class , 'menu_category_id');
    }
    public function poster()
    {
        return $this->belongsTo(AZRestaurantPoster::class , 'poster_id');
    }
}
