<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;


class CarFeatures extends Model
{
    use HasFactory,SoftDeletes;

    protected $fillable = [
        'uuid',
        'feature_id',
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

    public function Car(){
        return $this->belongsTo(Car::class,'car_id','uuid');
    }

    public function Feature(){
        return $this->belongsTo(Feature::class,'feature_id','uuid');
    }
}
