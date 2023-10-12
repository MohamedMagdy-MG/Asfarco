<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;
use Laravel\Sanctum\HasApiTokens;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Support\Str;



class User extends Authenticatable implements JWTSubject
{
    use HasApiTokens, HasFactory, Notifiable;


    protected $fillable = [
        'uuid',
        'name',
        'email',
        'mobile',
        'password',
        'gender',
        'image',
        'language',
        'longitude',
        'latitude',
        'firebasetoken',
        'register_type',
        'country_id',
        'active',

        'verify_document',
        'verify_document_at',

        'email_verified_at',
        
        'Verify_at',
        'otp',
        'Reset_at',
        'otp_reset',
        
    ];

    
    protected $hidden = [
        // 'password',
        'remember_token',
    ];

    
    protected $casts = [
        'email_verified_at' => 'datetime',
        'Verify_at' => 'datetime',
        'Reset_at' => 'datetime',
        'created_at'  => 'datetime',
    ];
    

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    
    public function getJWTCustomClaims()
    {
        return [];
    }

    
    protected static function booted()
    {
        static::creating(function ($model) {
            $model->uuid = Str::random(4) . '-' . Str::random(4); 
        });
    }


    public function Country(){
        return $this->belongsTo(Country::class,'country_id','id');
    }


    public function City(){
        return $this->belongsTo(City::class,'city_id','id');
    }

    public function Favourites(){
        return $this->hasMany(CarFavourites::class,'user_id','uuid');
    }

    public function Documents(){
        return $this->hasMany(UserDocument::class,'user_id','uuid');
    }

    public function Payments(){
        return $this->hasMany(UserPayment::class,'user_id','uuid');
    }

    public function Address(){
        return $this->hasMany(UserAddress::class,'user_id','uuid');
    }

    



    

   
   
}
