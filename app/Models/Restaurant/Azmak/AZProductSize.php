<?php

namespace App\Models\Restaurant\Azmak;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AZProductSize extends Model
{
    use HasFactory;
    protected $table = 'a_z_product_sizes';
    protected $fillable = [
        'product_id',
        'name_ar',
        'name_en',
        'price',
        'calories',
        'status',

    ];

    public function product()
    {
        return $this->belongsTo(AZProduct::class , 'product_id');
    }
}
