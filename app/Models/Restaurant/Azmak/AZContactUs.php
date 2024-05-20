<?php

namespace App\Models\Restaurant\Azmak;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Restaurant;

class AZContactUs extends Model
{
    use HasFactory;
    protected $table = 'a_z_contact_us';
    protected $fillable = [
        'restaurant_id',
        'name',
        'email',
        'message',
        'reply',
    ];

    public function restaurant()
    {
        return $this->belongsTo(Restaurant::class , 'restaurant_id');
    }
}
