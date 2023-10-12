<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;


class CarFavourites extends Model
{
    use HasFactory,SoftDeletes;

    protected $fillable = [
        'uuid',
        'user_id',
        'car_id'
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

    public function Car(){
        return $this->belongsTo(Car::class,'car_id','uuid');
    }
}
