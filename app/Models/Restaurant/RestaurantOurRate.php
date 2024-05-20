<?php

namespace App\Models\Restaurant;

use App\Models\Restaurant;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RestaurantOurRate extends Model
{
    use HasFactory;
    protected $table = 'restaurant_our_rates';
    protected $fillable = [
        'restaurant_id',
    ];

    public function restaurant()
    {
        return $this->belongsTo(Restaurant::class , 'restaurant_id');
    }
    public function answers()
    {
        return $this->hasMany(RestaurantRateUsAnswer::class , 'our_rate_id');
    }
}
