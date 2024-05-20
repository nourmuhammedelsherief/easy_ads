<?php

namespace App\Models\Restaurant\Azmak;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AZOption extends Model
{
    use HasFactory;
    protected $table = 'a_z_options';
    protected $fillable = [
        'restaurant_id',
        'modifier_id',
        'name_ar',
        'name_en',
        'is_active',
        'price',
        'calories',
        'easy_id',
    ];

    public function restaurant()
    {
        return $this->belongsTo(Restaurant::class , 'restaurant_id');
    }
    public function modifier()
    {
        return $this->belongsTo(AZModifier::class , 'modifier_id');
    }

}
