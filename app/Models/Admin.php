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


class Admin extends Authenticatable implements JWTSubject
{
    use HasApiTokens, HasFactory, Notifiable;
    
    protected $fillable = [
        'uuid',
        'name_en',
        'name_ar',
        'email',
        'password',
        'gender',
        'image',
        'language',
        'role',     //Admin , Manager , Branch Manager , Branch Employee
        'firebasetoken',
        'active',
        'Verify_at',
        'email_verified_at',
        'branch_id',
        'otp'
        
    ];

    
    protected $hidden = [
        'password',
        'remember_token',
    ];

    
    protected $casts = [
        'email_verified_at' => 'datetime',
        'Verify_at' => 'datetime',
        'created_at' => 'datetime'
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

    public function Branch(){
        return $this->belongsTo(Branch::class,'branch_id','uuid');
    }

    public function Notifications(){
        return $this->hasMany(Notification::class,'admin_id','uuid');
    }


   


   
   
}
