<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;


class CarBrand extends Model
{
    use HasFactory,SoftDeletes;

    protected $fillable = [
        'uuid',
        'name_en',
        'name_ar',
        'image'
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

    public function CarModels(){
        return $this->hasMany(CarModel::class,'car_brand_id','id');
    }

    public function Cars(){
        return $this->hasMany(Car::class,'brand_id','uuid');
    }
}
