<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RestaurantTermsCondition extends Model
{
    use HasFactory;
    protected $table = 'restaurant_terms_conditions';
    protected $fillable = [
        'restaurant_id',
        'terms_ar',
        'terms_en',
    ];

    public function restaurant()
    {
        return $this->belongsTo(Restaurant::class , 'restaurant_id');
    }
}
