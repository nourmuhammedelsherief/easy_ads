<?php

namespace App\Models\Restaurant;

use App\Models\Restaurant;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RestaurantRateUsQuestion extends Model
{
    use HasFactory;
    protected $table = 'restaurant_rate_us_questions';
    protected $fillable = [
        'restaurant_id',
        'question_ar',
        'question_en',
        'more_option',
        'arrange',
    ];

    public function restaurant()
    {
        return $this->belongsTo(Restaurant::class , 'restaurant_id');
    }
}
