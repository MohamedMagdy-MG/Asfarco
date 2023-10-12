<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;


class UserAddress extends Model
{
    use HasFactory,SoftDeletes;

    protected $fillable = [
        'uuid',
        'label',
        'address',
        'city_id',
        'user_id',
    ];
    protected $casts = [];
    protected $hidden = [
        'deleted_at',
        'updated_at'
    ];


    protected static function booted()
    {
        static::creating(function ($model) {
            $model->uuid = Str::random(4) . '-' . Str::random(4); 
        });
    }

    public function User(){
        return $this->belongsTo(User::class,'user_id','uuid');
    }

    public function City(){
        return $this->belongsTo(City::class,'city_id','id');
    }
}
