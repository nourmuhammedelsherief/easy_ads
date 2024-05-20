<?php

namespace App\Models\Restaurant\Azmak;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AZProductModifier extends Model
{
    use HasFactory;
    protected $table = 'a_z_product_modifiers';
    protected $fillable = [
        'product_id',
        'modifier_id',
    ];

    public function product()
    {
        return $this->belongsTo(AZProduct::class , 'product_id');
    }
    public function modifier()
    {
        return $this->belongsTo(AZModifier::class , 'modifier_id');
    }
}
