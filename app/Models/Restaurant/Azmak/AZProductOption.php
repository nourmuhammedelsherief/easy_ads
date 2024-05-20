<?php

namespace App\Models\Restaurant\Azmak;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AZProductOption extends Model
{
    use HasFactory;
    protected $table = 'a_z_product_options';
    protected $fillable = [
        'product_id',
        'option_id',
        'modifier_id',
        'max',
        'min'
    ];
    public function product()
    {
        return $this->belongsTo(AZProduct::class , 'product_id');
    }
    public function modifier()
    {
        return $this->belongsTo(AZModifier::class , 'modifier_id');
    }
    public function option()
    {
        return $this->belongsTo(AZOption::class , 'option_id');
    }
}
