<?php

namespace App\Models\Restaurant\Azmak;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AZProductDay extends Model
{
    use HasFactory;
    protected $table = 'a_z_product_days';
    protected $fillable = [
        'product_id',
        'day_id',
    ];

    public function product()
    {
        return $this->belongsTo(AZProduct::class , 'product_id');
    }
    public function day()
    {
        return $this->belongsTo(Day::class , 'day_id');
    }
}
