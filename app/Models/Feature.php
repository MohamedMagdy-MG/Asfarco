<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;


class Feature extends Model
{
    use HasFactory,SoftDeletes;

    protected $fillable = [
        'uuid',
        'name_en',
        'name_ar'
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

    public function CarFeature(){
        return $this->hasOne(CarFeatures::class,'feature_id','uuid');
    }
}
