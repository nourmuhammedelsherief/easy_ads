<?php

namespace App\Models\Restaurant\Azmak;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AZModifier extends Model
{
    use HasFactory;
    protected $table = 'a_z_modifiers';
    protected $fillable = [
        'restaurant_id',
        'name_ar',
        'name_en',
        'is_ready',
        'choose',
        'sort',
        'custom',
        'easy_id',
    ];

    public function restaurant()
    {
        return $this->belongsTo(Restaurant::class , 'restaurant_id');
    }
}
