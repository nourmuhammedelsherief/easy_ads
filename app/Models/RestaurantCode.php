<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RestaurantCode extends Model
{
    use HasFactory;
    protected $table = 'restaurant_code';
    protected $fillable = [
        'restaurant_id',
        'name',
        'header',
        'footer',
    ];

    public function restaurant()
    {
        return $this->belongsTo(Restaurant::class , 'restaurant_id');
    }
}
