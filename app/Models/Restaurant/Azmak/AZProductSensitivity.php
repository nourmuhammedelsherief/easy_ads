<?php

namespace App\Models\Restaurant\Azmak;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\AZRestaurantSensitivity;

class AZProductSensitivity extends Model
{
    use HasFactory;
    protected $table = 'a_z_product_sensitivities';
    protected $fillable = [
        'product_id',
        'sensitivity_id',
    ];

    public function product()
    {
        return $this->belongsTo(AZProduct::class , 'product_id');
    }
    public function sensitivity()
    {
        return $this->belongsTo(AZRestaurantSensitivity::class , 'sensitivity_id');
    }
}
