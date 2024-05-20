<?php

namespace App\Models\Restaurant;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RestaurantRateUsAnswer extends Model
{
    use HasFactory;
    protected $table = 'restaurant_rate_us_answers';
    protected $fillable = [
        'our_rate_id',
        'rate_id',
        'answer',
    ];
    public function our_rate()
    {
        return $this->belongsTo(RestaurantOurRate::class , 'our_rate_id');
    }
    public function rate()
    {
        return $this->belongsTo(RestaurantRateUsQuestion::class , 'rate_id');
    }
}
