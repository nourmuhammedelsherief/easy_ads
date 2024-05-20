<?php

namespace App\Models;

use App\Models\ServiceProvider\ServiceProvider;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RestaurantContactUs extends Model
{
    use HasFactory;
    protected $table = 'restaurant_contact_us';
    protected $fillable = [
        'restaurant_id',
        'service_provider_id' ,
        'url',
        'image',
        'sort',
        'title_en' , 'title_ar'  , 'status' ,
        'link_id' , 'main_id' ,
        'description_ar' , 'description_en' ,
    ];
    public function getTitleAttribute(){
        return app()->getLocale() == 'ar' ? $this->title_ar : $this->title_en;
    }
    public function getDescriptionAttribute(){
        return app()->getLocale() == 'ar' ? $this->description_ar : $this->description_en;
    }
    public function restaurant()
    {
        return $this->belongsTo(Restaurant::class , 'restaurant_id');
    }
    public function serviceProvider()
    {
        return $this->belongsTo(ServiceProvider::class , 'service_provider_id');
    }
    public function link(){
        return $this->belongsTo(RestaurantContactUsLink::class , 'link_id');
    }
    public function main(){
        return $this->belongsTo(RestaurantContactUs::class , 'main_id');
    }
    public function childs(){
        return $this->hasMany(RestaurantContactUs::class , 'main_id');
    }

}
