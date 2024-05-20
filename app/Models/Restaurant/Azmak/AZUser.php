<?php

namespace App\Models\Restaurant\Azmak;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Models\Country;

class AZUser extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $guard = 'web';


    protected $table = 'a_z_users';
    protected $fillable = [
        'name',
        'email',
        'password',
        'company',
        'company_type',
        'phone_number',
        'verification_code',
        'remember_token',
        'country_id',
    ];

    public function country()
    {
        return $this->belongsTo(Country::class , 'country_id');
    }
}
