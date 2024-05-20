<?php

namespace App\Models\Restaurant\Azmak;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AZRestaurantSubCategory extends Model
{
    use HasFactory;
    protected $table = 'a_z_restaurant_sub_categories';
    protected $fillable = [
        'menu_category_id',
        'name_ar',
        'name_en' ,
        'image',
        'easy_id'
    ];
    public function getNameAttribute(){
        return app()->getLocale() == 'ar' ? $this->name_ar : $this->name_en;
    }
    public function getImagePathAttribute(){
        return empty($this->image) ? null : 'uploads/sub_menu_categories/' . $this->image;
    }

    public function restaurant_category()
    {
        return $this->belongsTo(AZMenuCategory::class , 'menu_category_id');
    }
}
