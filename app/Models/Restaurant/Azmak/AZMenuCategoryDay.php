<?php

namespace App\Models\Restaurant\Azmak;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AZMenuCategoryDay extends Model
{
    use HasFactory;
    protected $table = 'a_z_menu_category_days';
    protected $fillable = [
        'menu_category_id',
        'day_id'
    ];

    public function menu_category(){
        return $this->belongsTo(AZMenuCategory::class , 'menu_category_id');
    }
    public function day()
    {
        return $this->belongsTo(Day::class , 'day_id');
    }
}
